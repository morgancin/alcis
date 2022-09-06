<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_activity_type';
    protected $fillable = ['user_id', 'name', 'type'];
}
