<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    //use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $dates = ['activity_date'];


    protected $fillable = ['account_id', 'prospect_id', 'activity_subject_id', 'activity_date', 'start_date', 'start_time', 'end_date', 'end_time', 'comments', 'observations', 'activity_result_id'];

    //protected $perPage = 30;
    /*
    protected static function boot(){
        parent::boot();
        self::creating(function(Activity $activity){
            $activity->user_id = auth()->id();
        });
    }
    */

    protected $appends = ['activity_date_format'];

    ////////////RELATIONSHIPS
    /**
     * Get the client that owns the activity.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Prospect::class, 'prospect_id', 'id');
    }

    /**
     * Get the quote associated with the activity.
     */
    public function quote(): HasOne
    {
        return $this->hasOne(Quote::class, 'activity_id', 'id');
    }

    /**
     * Get the activity subject that owns the activity.
     */
    public function activity_subject(): BelongsTo
    {
        return $this->belongsTo(ActivitySubject::class, 'activity_subject_id', 'id');
    }

    /**
     * Get the activity result that owns the activity.
     */
    public function activity_result(): BelongsTo
    {
        return $this->belongsTo(ActivityResult::class, 'activity_result_id', 'id');
    }

    ////////////ACCESSORS
    public function getActivityDateFormatAttribute()
    {
        return $this->activity_date->format('d/m/Y');
    }
}
