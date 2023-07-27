<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProspectingSource extends Model
{
    //use HasFactory;
    protected $fillable = ['account_id', 'name', 'prospecting_source_id', 'created_user_id', 'updated_user_id', 'active'];

    protected $with = ['prospecting_means'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ProspectingSource $prospecting_source){
            $prospecting_source->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the account for the prospecting source.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Get the means for the prospecting source.
     */
    public function prospecting_means(): HasMany
    {
        return $this->hasMany(ProspectingSource::class, 'prospecting_source_id', 'id');
    }

    /**
     * Get the source for the origin medium.
     */
    public function prospecting_source(): BelongsTo
    {
        return $this->belongsTo(ProspectingSource::class, 'prospecting_source_id', 'id');
    }

    /**
     * Get the teams for the source.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'prospecting_source_team', 'prospecting_source_id', 'team_id');
    }
}
