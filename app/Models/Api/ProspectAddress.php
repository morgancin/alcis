<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectAddress extends Model
{
    //use HasFactory;
    protected $fillable = ['prospect_id', 'zipcode', 'street', 'outdoor', 'indoor', 'suburb', 'town', 'city', 'state', 'country', 'alias'];
}
