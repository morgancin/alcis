<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteItems extends Model
{
    //use HasFactory;
    protected $fillable = ['quote_id', 'product_id', 'quantity', 'price', 'coupon_code', 'discount_percent', 'discount_amount', 'total'];

    ////////////RELATIONSHIPS
    /**
     * Get the quote for the quote item.
     */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'id');
    }

    /**
     * Get the product for the quote item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
