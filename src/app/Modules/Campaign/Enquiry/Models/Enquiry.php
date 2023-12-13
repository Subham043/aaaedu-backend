<?php

namespace App\Modules\Campaign\Enquiry\Models;

use App\Modules\Campaign\Campaign\Models\Campaign;
use App\Modules\Campaign\Enquiry\Jobs\CampaignFormEmailJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Enquiry extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'campaign_enquiries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'campaign_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new CampaignFormEmailJob($data));
        });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('campaign_enquiries')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Enquiry with name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
