<?php

namespace App\Modules\Enquiry\ChatbotForm\Models;

use App\Modules\Enquiry\ChatbotForm\Jobs\ChatbotFormEmailJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatbotForm extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'chatbot_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lead_id',
        'name',
        'email',
        'phone',
        'ip_address',
        'country',
        'latitude',
        'longitude',
        'browser',
        'is_mobile',
        'visit_question',
        'admission_question',
        'contact_question',
        'multiple_choice_query',
        'school_course_question',
        'course_location_question',
        'course_standard_question',
        'final_callback_question',
        'schedule_callback_question',
        'status',
        'page_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_mobile' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        self::updated(function ($data) {
            if(!empty($data->name) && !empty($data->email) && !empty($data->phone) && empty($data->multiple_choice_query)){
                dispatch(new ChatbotFormEmailJob($data));
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('chatbot enquiries')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Chatbot enquiry with user name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
