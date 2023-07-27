<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'is_carousel', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Team $team){
            $team->created_user_id = auth()->id();
        });

        self::updating(function(Team $team){
            $team->updated_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the users for the team.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }

    /**
     * Get the prospecting source for the team.
     */
    public function prospecting_sources(): BelongsToMany
    {
        return $this->belongsToMany(ProspectingSource::class, 'prospecting_source_team', 'team_id', 'prospecting_source_id');
    }
}
