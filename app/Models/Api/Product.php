<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    //use HasFactory;
    protected $fillable = ['account_id', 'category_id', 'sku', 'name', 'description', 'quantity'];

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
     * Get the items for the quote.
     */
    public function quote_items(): HasMany
    {
        return $this->hasMany(QuoteItems::class, 'product_id', 'id');
    }

    /**
     * Get the category for the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get the prices lists for the product.
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_id', 'id');
    }

    /**
     * Get the lists prices for the product.
     */
    /*
    public function prices_lists(): BelongsToMany
    {
        return $this->belongsToMany(PriceList::class, 'price_list_product', 'product_id', 'price_list_id');
    }
    */
}
