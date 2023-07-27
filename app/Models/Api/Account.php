<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Account extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'tax_id', 'phone_office', 'website', 'address', 'potential_value', 'comments', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Account $account){
            $account->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the pipelines for the account.
     */
    public function pipelines(): HasMany
    {
        return $this->hasMany(Pipeline::class, 'account_id', 'id');
    }

    /**
     * Get the users for the account.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'account_user', 'account_id', 'user_id');
    }
}
