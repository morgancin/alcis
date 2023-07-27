<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentTerm extends Model
{
    //use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'active',
        'extra_days',
        'created_user_id',
        'updated_user_id',
        'active'
    ];

    protected static function boot(){
        parent::boot();
        self::creating(function(PaymentTerm $payment_term){
            $payment_term->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the document associated with the payment term.
     */
    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'payment_terms_id', 'id');
    }
}
