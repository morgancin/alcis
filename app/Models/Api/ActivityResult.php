<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityResult extends Model
{
    //use HasFactory;
    protected $fillable = ['activity_type_id', 'name', 'tracking_type'];

    ////////////RELATIONSHIPS
    /**
     * Get the activities for the activity result.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'activity_result_id', 'id');
    }

    /**
     * Get the activity type for the activity result.
     */
    public function activity_type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id', 'id');
    }
}
