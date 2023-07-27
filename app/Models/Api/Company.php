<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'phone', 'website', 'address', 'potential_value', 'tax_id', 'comments', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Company $company){
            $company->created_user_id = auth()->id();
        });
    }

    /**
     * Get the prices for the prices lists.
     */
    public function prospects(): HasMany
    {
        return $this->hasMany(Prospect::class, 'company_id', 'id');
    }
}
