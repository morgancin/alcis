<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    //use HasFactory;
    protected $fillable = [
                            'code',
                            'type',
                            'class',
                            'total',
                            'status',
                            //'user_id',
                            'comments',
                            'ship_date',
                            'reference',
                            'sub_total',
                            'account_id',
                            'tax_amount',
                            'expires_at',
                            'canceled_at',
                            'prospect_id',
                            'currency_id',
                            'activity_id',
                            'exchange_rate',
                            'contact_person',
                            'order_status_id',
                            'discount_amount',
                            'discount_percent',
                            'payment_terms_id',
                            'payment_method_id',
                            'shipping_address_id',
                            'invoicing_address_id',
                            'contact_person_phone',
                            'created_user_id',
                            'updated_user_id',
                            'active'
                        ];

    protected static function boot(){
        parent::boot();
        self::creating(function(Document $document){
            $document->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the user for the quote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_id', 'id');
    }

    /**
     * Get the items for the quote.
     */
    //public function items(): HasMany
    public function products(): HasMany
    {
        return $this->hasMany(QuoteItems::class, 'quote_id', 'id');
    }

    /**
     * Get the quote for the activity.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /**
     * Get the payment term for the activity.
     */
    public function payment_term(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_terms_id', 'id');
    }

    /**
     * Get the payment method term for the activity.
     */
    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
