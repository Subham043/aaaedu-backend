<?php

namespace App\Modules\AdmissionTest\Models;

use App\Enums\AdmissionTestClassEnum;
use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AdmissionTest extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'admission_tests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'school_name',
        'class',
        'father_name',
        'father_phone',
        'father_email',
        'mother_name',
        'mother_phone',
        'mother_email',
        'program',
        'mode',
        'address',
        'exam_date',
        'exam_center',
        'image',
        'amount',
        'receipt',
        'payment_status',
        'razorpay_signature',
        'razorpay_order_id',
        'razorpay_payment_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'mode' => ExamMode::class,
        'class' => AdmissionTestClassEnum::class,
        'payment_status' => PaymentStatus::class,
    ];

    protected $attributes = [
        'mode' => ExamMode::OFFLINE,
        'class' => AdmissionTestClassEnum::SEVENTH,
        'payment_status' => PaymentStatus::PENDING,
    ];

    public $image_path = 'admission_tests';

    protected $appends = ['image_link'];

    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->image_path.'/'.$value,
        );
    }

    protected function imageLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->image),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('admission_tests')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Admission with user name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
