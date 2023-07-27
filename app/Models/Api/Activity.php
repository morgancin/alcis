<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\UserScope;
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
	protected $dates = ['activity_date', 'start_date', 'end_date'];

    protected $fillable = ['account_id', 'prospect_id', 'pipeline_stage_id', 'activity_result_id', 'activity_subject_id', 'activity_date', 'start_date', 'end_date', 'on_time', 'potential_value', 'comments', 'observations', 'created_user_id', 'updated_user_id', 'active'];

    //protected $perPage = 30;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

    protected static function boot(){
        parent::boot();
        self::creating(function(Activity $activity){
            $activity->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the prospect that owns the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id', 'id');
    }

    /**
     * Get the prospect that owns the activity.
     */
    public function prospect(): BelongsTo
    {
        return $this->belongsTo(Prospect::class, 'prospect_id', 'id');
    }

    /**
     * Get the prospect that owns the activity.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Get the quote associated with the activity.
     */
    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'activity_id', 'id');
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
}
