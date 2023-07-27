<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectAddress extends Model
{
    //use HasFactory;
    protected $fillable = [
                            'type',
                            'town',
                            'city',
                            'state',
                            'alias',
                            'street',
                            'indoor',
                            'suburb',
                            'country',
                            'outdoor',
                            'zipcode',
                            'prospect_id',
                            'created_user_id',
                            'updated_user_id',
                            'active'
                        ];

    protected static function boot(){
        parent::boot();
        self::creating(function(ProspectAddress $prospect_address){
            $prospect_address->created_user_id = auth()->id();
        });
    }
}
