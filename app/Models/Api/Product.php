<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    //use HasFactory;
    protected $fillable = ['category_id', 'sku', 'name', 'description', 'quantity'];

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
}
