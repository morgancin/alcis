<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'type', 'account_id'];
}
