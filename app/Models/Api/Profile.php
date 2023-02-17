<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'language'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Profile $profile){
            $profile->user_id = auth()->id();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
