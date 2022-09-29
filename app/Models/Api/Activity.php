<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'client_id', 'activity_type_id', 'activity_subject_id', 'activity_date', 'start_date', 'start_time', 'end_date', 'end_time', 'comments'];

    //protected $perPage = 30;

    protected static function boot(){
        parent::boot();
        self::creating(function(Activity $activity){
            $activity->user_id = auth()->id();
        });
    }
}
