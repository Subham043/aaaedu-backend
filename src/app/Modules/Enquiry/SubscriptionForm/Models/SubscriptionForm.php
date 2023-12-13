<?php

namespace App\Modules\Enquiry\SubscriptionForm\Models;

use App\Enums\Branch;
use App\Enums\RequestType;
use App\Modules\Enquiry\SubscriptionForm\Jobs\SubscriptionFormEmailJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SubscriptionForm extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'page_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new SubscriptionFormEmailJob($data));
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('subscriptions')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Subscription with email ".$this->email." has been {$eventName}";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
