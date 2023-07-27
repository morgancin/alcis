<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PriceList extends Model
{
    //use HasFactory;
    protected $fillable = ['account_id', 'name', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(PriceList $price_list){
            $price_list->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the prices for the prices lists.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'currency_price_list_product', 'price_list_id', 'product_id')->withPivot('price');
    }
}
