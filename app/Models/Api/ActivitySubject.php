<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivitySubject extends Model
{
    //use HasFactory;
    protected $fillable = ['activity_type_id', 'name', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ActivitySubject $activity_subject){
            $activity_subject->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the activities for the activity subject.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'activity_subject_id', 'id');
    }

    public function activity_type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id', 'id');
    }
}
