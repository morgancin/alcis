<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_client';
    protected $fillable = ['rfc', 'age', 'curp', 'city', 'email', 'state', 'gender', 'user_id', 'lastname', 'firstname', 'extension', 'homephone', 'profession', 'officephone', 'mobilephone', 'servicepriority', 'prospectingorigin', 'prospectingmedium'];

    //protected $perPage = 30;

    /*
    protected static function boot(){
        parent::boot();
        self::creating(function(Client $client){
            $client->user_id = auth()->id();
        });
    }
    */
}
