<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    //use HasFactory;
    protected $fillable = ['code', 'name', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Currency $currency){
            $currency->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the prices for the currency.
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'currency_id', 'id');
    }
}
