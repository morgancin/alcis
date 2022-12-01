<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'client_id', 'activity_type_id', 'activity_subject_id', 'activity_date', 'start_date', 'start_time', 'end_date', 'end_time', 'comments'];

    //protected $perPage = 30;

    protected static function boot(){
        parent::boot();
        self::creating(function(Activity $activity){
            $activity->user_id = auth()->id();
        });
    }

    /**
     * Get the client that owns the activity.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * Get the activity type that owns the activity.
     */
    public function activity_type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id', 'id');
    }

    /**
     * Get the activity subject that owns the activity.
     */
    public function activity_subject(): BelongsTo
    {
        return $this->belongsTo(ActivitySubject::class, 'activity_subject_id', 'id');
    }
}
