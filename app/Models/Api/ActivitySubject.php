<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivitySubject extends Model
{
    //use HasFactory;
    protected $fillable = ['activity_type_id', 'name'];

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
