<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    //use HasFactory;
    //protected $fillable = ['user_id', 'product_id', 'currency_id', 'price_list_id', 'price'];
    protected $fillable = ['currency_id', 'price_list_id', 'price'];

    protected $with = ['currency', 'prices_list'];

    /*
    protected static function boot()
    {
        parent::boot();
        self::creating(function(Price $price)
        {
            $price->user_id = auth()->id();
        });
    }
    */

    ////////////RELATIONSHIPS
    /**
     * Get the currency for the price.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    /**
     * Get the prices lists for the price.
     */
    public function prices_list(): BelongsTo
    {
        return $this->belongsTo(PriceList::class, 'price_list_id', 'id');
    }
}
