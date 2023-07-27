<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentMethod extends Model
{
    //use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'type',
        'created_user_id',
        'updated_user_id',
        'active'
    ];

    protected static function boot(){
        parent::boot();
        self::creating(function(PaymentMethod $payment_method){
            $payment_method->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the document associated with the payment method.
     */
    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'payment_method_id', 'id');
    }
}
