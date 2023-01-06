<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'category_group_id', 'active', 'order', 'name', 'image'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function(Category $category)
        {
            $category->user_id = auth()->id();
        });
    }

    protected $with = ['subcategories'];

    ////////////RELATIONSHIPS
    /**
     * Get the subcategories for the category.
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    /**
     * Get the category for the subcategory.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
