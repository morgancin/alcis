<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'name'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function(PriceList $price_list)
        {
            $price_list->user_id = auth()->id();
        });
    }
}
