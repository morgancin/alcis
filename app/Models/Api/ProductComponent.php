<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductComponent extends Model
{
    //use HasFactory;
    protected $fillable = ['product_id', 'name', 'quantity', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ProductComponent $product_component){
            $product_component->created_user_id = auth()->id();
        });
    }

    /**
     * Get the product for the component.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
