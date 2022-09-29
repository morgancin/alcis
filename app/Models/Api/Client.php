<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'client_medium_origin_id', 'first_name', 'last_name', 'second_last_name', 'gender', 'birth_date', 'age', 'birth_place', 'email', 'phone_office', 'phone_mobile', 'phone_home', 'profession', 'rfc', 'curp', 'service_priority', 'extension'];

    //protected $perPage = 30;

    protected static function boot(){
        parent::boot();
        self::creating(function(Client $client){
            $client->user_id = auth()->id();
        });
    }
}
