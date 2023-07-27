<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'type', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function(Tag $tag){
            $tag->created_user_id = auth()->id();
        });
    }
}
