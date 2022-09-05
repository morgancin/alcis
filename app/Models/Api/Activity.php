<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_activity';
    protected $fillable = ['user_id', 'client_id', 'activity_type_id', 'activity_subject_id', 'activity_date', 'start_date', 'start_time', 'end_date', 'end_time', 'comments'];

    //protected $perPage = 30;
}
