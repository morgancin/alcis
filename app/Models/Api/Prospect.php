<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prospect extends Model
{
    //use HasFactory;
    protected $fillable = [
        'age',
        'email',
        'gender',
        'tax_id',
        'priority',
        'extension',
        'last_name',
        'tax_regime',
        'birth_date',
        'account_id',
        'company_id',
        'first_name',
        'phone_home',
        'profession',
        'birth_place',
        'phone_office',
        'phone_mobile',
        'population_reg',
        'potential_value',
        'principal_usage',
        'second_last_name',
        'pipeline_stage_id',
        'prospecting_mean_id',
        'created_user_id',
        'updated_user_id',
        'active'
    ];

    //protected $perPage = 30;
    protected $appends = ['full_name'];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

    protected static function boot(){
        parent::boot();
        self::creating(function(Prospect $prospect){
            $prospect->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the activity associated with the client.
     */
    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class, 'client_id', 'id');
    }

    /**
     * Get the company that owns the activity.
     */
    /*
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    */

    ////////////ACCESSORS
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name.' '.$this->second_last_name;
    }
}
