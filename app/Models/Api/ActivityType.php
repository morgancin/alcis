<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityType extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'type', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ActivityType $activity_type){
            $activity_type->created_user_id = auth()->id();
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

    public function activity_results(): HasMany
    {
        return $this->hasMany(ActivityResult::class, 'activity_type_id', 'id');
    }

    public function activity_subjects(): HasMany
    {
        return $this->hasMany(ActivitySubject::class, 'activity_type_id', 'id');
    }
}
