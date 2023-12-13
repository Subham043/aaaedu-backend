<?php

namespace App\Modules\Enquiry\CourseRequestForm\Models;

use App\Modules\Course\Branch\Models\Branch;
use App\Modules\Course\Course\Models\Course;
use App\Modules\Enquiry\CourseRequestForm\Jobs\CourseRequestFormEmailJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CourseRequestForm extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'course_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'course_id',
        'branch_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new CourseRequestFormEmailJob($data));
        });
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withDefault();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('course request form enquiries')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Course request form enquiry with user name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
