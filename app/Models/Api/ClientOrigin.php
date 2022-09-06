<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOrigin extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_client_origin';
    protected $fillable = ['user_id', 'description', 'parent_id_client_medium'];
}
