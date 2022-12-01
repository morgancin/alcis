<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'client_medium_origin_id', 'first_name', 'last_name', 'second_last_name', 'gender', 'birth_date', 'age', 'birth_place', 'email', 'phone_office', 'phone_mobile', 'phone_home', 'profession', 'rfc', 'curp', 'service_priority', 'extension'];

    //protected $perPage = 30;

    protected static function boot(){
        parent::boot();
        self::creating(function(Client $client){
            $client->user_id = auth()->id();
        });
    }

    protected $casts = [
        'full_name' => 'string',
    ];

    ////////////RELATIONSHIPS
    /**
     * Get the activity associated with the client.
     */
    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class, 'client_id', 'id');
    }

    ////////////ACCESSORS
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name.' '.$this->second_last_name;
    }
}
