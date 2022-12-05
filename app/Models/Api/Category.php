<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
