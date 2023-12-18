<?php

namespace App\Modules\JobOpening\JobEnquiry\Models;

use App\Modules\JobOpening\JobEnquiry\Jobs\JobEnquiryEmailJob;
use App\Modules\JobOpening\JobOpening\Models\JobOpening;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class JobEnquiry extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'job_enquiries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cv',
        'job_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public $cv_path = 'job_openings';

    protected $appends = ['cv_link'];

    protected function cv(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->cv_path.'/'.$value,
        );
    }

    protected function cvLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->cv),
        );
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new JobEnquiryEmailJob($data));
        });
    }

    public function job()
    {
        return $this->belongsTo(JobOpening::class, 'job_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('job_enquiry')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Job Enquiry from ".$this->name." has been {$eventName}";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
