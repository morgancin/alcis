<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'role',
        'name',
        'email',
        'password',
        'user_id',
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
        return $this->hasOne(Api\Profile::class, 'user_id', 'id');
    }

    public function accounts(): BelongsToMany
    {
        //return $this->belongsToMany(Product::class, 'price_list_product', 'price_list_id', 'product_id');
        //return $this->belongsToMany(Api\Account::class, 'account_user', 'account_id', 'user_id');
        return $this->belongsToMany(Api\Account::class, 'account_user', 'user_id', 'account_id');
    }
}
