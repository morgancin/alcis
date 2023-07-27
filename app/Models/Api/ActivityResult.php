<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityResult extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'activity_type_id', 'pipeline_stage_id', 'is_tracking', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ActivityResult $activity_result){
            $activity_result->created_user_id = auth()->id();
        });
    }

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
