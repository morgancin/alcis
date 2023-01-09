<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PriceList extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'name'];

    //protected $with = ['prices'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function(PriceList $price_list)
        {
            $price_list->user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the prices for the prices lists.
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'price_list_id', 'id');
    }

    /**
     * Get the products for the list price.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'price_list_product', 'price_list_id', 'product_id');
    }
}
