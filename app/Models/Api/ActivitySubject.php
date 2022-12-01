<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivitySubject extends Model
{
    //use HasFactory;
    protected $fillable = ['activity_type_id', 'user_id', 'name'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ActivitySubject $activitysubject){
            $activitysubject->user_id = auth()->id();
        });
    }

    /**
     * Get the activities for the activity subject.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'activity_subject_id', 'id');
    }
}
