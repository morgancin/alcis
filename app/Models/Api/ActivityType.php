<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityType extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'name', 'type'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ActivityType $activitytype){
            $activitytype->user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the activities for the activity type.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'activity_type_id', 'id');
    }
}
