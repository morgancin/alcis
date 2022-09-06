<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitySubject extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_activity_subject';
    protected $fillable = ['activity_type_id', 'user_id', 'name'];
}
