<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityResult extends Model
{
    //use HasFactory;
    protected $fillable = ['activity_type_id', 'name', 'tracking'];
}
