<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_activity';
    protected $fillable = ['title', 'type', 'comment', 'schedule_to', 'schedule_from', 'is_done', 'user_id', 'location'];

    //protected $perPage = 30;
}
