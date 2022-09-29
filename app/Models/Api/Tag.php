<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'type', 'user_id'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Tag $tag){
            $tag->user_id = auth()->id();
        });
    }
}
