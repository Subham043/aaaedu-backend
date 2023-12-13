<?php

namespace App\Modules\Enquiry\ScholarForm\Models;

use App\Enums\ScholarCourse;
use App\Enums\ScholarBranch;
use App\Modules\Enquiry\ScholarForm\Jobs\ScholarFormEmailJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ScholarForm extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'scholar_form_enquiries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'course',
        'branch',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'course' => ScholarCourse::class,
        'branch' => ScholarBranch::class,
    ];

    protected $attributes = [
        'course' => ScholarCourse::SCHOLAR,
        'branch' => ScholarBranch::VIJAYNAGAR_SCHOLAR,
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new ScholarFormEmailJob($data));
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('scholar form enquiries')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Scholar form enquiry with user name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
