<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $with = ['accounts'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'password',
        'created_user_id',
        'updated_user_id',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    ////////////RELACIONES////////////
    public function profile(): HasOne
    {
        return $this->hasOne(Api\Profile::class, 'created_user_id', 'id');
    }

    /**
     * Get the activities for the user.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Api\Activity::class, 'created_user_id', 'id');
    }

    /**
     * Get the accounts for the user.
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Api\Account::class, 'account_user', 'user_id', 'account_id');
    }

    /**
     * Get the teams for the user.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Api\Team::class, 'team_user', 'created_user_id', 'team_id');
    }
}
