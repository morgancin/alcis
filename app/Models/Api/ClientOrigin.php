<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOrigin extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'description', 'parent_id_client_medium'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ClientOrigin $clientorigin){
            $clientorigin->user_id = auth()->id();
        });
    }
}
