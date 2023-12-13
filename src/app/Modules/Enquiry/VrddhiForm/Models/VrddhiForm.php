<?php

namespace App\Modules\Enquiry\VrddhiForm\Models;

use App\Enums\VrddhiClassEnum;
use App\Enums\VrddhiSyllabusEnum;
use App\Modules\Enquiry\VrddhiForm\Jobs\VrddhiFormEmailJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class VrddhiForm extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'vrddhis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'school_name',
        'class',
        'father_name',
        'father_phone',
        'father_email',
        'mother_name',
        'mother_phone',
        'mother_email',
        'syllabus',
        'card',
        'phone',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'class' => VrddhiClassEnum::class,
        'syllabus' => VrddhiSyllabusEnum::class,
    ];

    protected $attributes = [
        'class' => VrddhiClassEnum::EIGHT,
        'syllabus' => VrddhiSyllabusEnum::ICSE,
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new VrddhiFormEmailJob($data));
        });
    }

    public $image_path = 'vrddhis';

    protected $appends = ['card_link'];

    protected function card(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->image_path.'/'.$value,
        );
    }

    protected function cardLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->card),
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('vrddhis')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Vrddhi with user name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
