<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_client_address';
    protected $fillable = ['client_id', 'street', 'outdoor', 'indoor', 'suburb', 'town', 'city', 'state', 'country', 'alias'];
}
