<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientOrigin extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'description', 'parent_id_client_medium'];

    protected static function boot(){
        parent::boot();
        self::creating(function(ClientOrigin $clientorigin){
            $clientorigin->user_id = auth()->id();
        });
    }

    //protected $hidden = ['origin_mediums', 'origin'];
    //protected $hidden = ['origin'];
    //protected $with = ['origin', 'origin_mediums'];   //FALLÓ
    protected $with = ['origin_mediums'];

    ////////////RELATIONSHIPS
    /**
     * Get the mediums for the client origin.
     */
    public function origin_mediums(): HasMany
    {
        return $this->hasMany(ClientOrigin::class, 'parent_id_client_medium', 'id');
    }

    /**
     * Get the origin for the origin medium.
     */
    public function origin(): BelongsTo
    {
        return $this->belongsTo(ClientOrigin::class, 'parent_id_client_medium', 'id');
    }
}
