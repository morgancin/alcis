<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    //use HasFactory;
    protected $fillable = ['user_id', 'activity_id', 'description', 'discount_percent', 'discount_amount', 'expire_at', 'sub_total', 'total'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function(Quote $quote)
        {
            $quote->user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the user for the quote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
}
