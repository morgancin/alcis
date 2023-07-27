<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    //use HasFactory;
    protected $fillable = ['account_id', 'prospect_id', 'prospecting_mean_id', 'first_name', 'last_name', 'second_last_name', 'email', 'comments', 'first_assignation_user_id', 'first_assignation_at', 'second_assignation_user_id', 'second_assignation_at', 'final_assignation_user_id', 'attended_at'];

    ////////////RELATIONSHIPS
    /**
     * Get the account associated with the lead.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Get the prospect associated with the lead.
     */
    public function prospect(): BelongsTo
    {
        return $this->belongsTo(Prospect::class, 'account_id', 'id');
    }

    /**
     * Get the prospecting mean associated with the lead.
     */
    public function prospecting_mean(): BelongsTo
    {
        return $this->belongsTo(ProspectingSource::class, 'prospecting_mean_id', 'id');
    }

    /**
     * Get the first assignation user associated with the lead.
     */
    public function first_assignation_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'first_assignation_user_id', 'id');
    }

    /**
     * Get the second assignation user associated with the lead.
     */
    public function second_assignation_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'second_assignation_user_id', 'id');
    }

    /**
     * Get the final assignation user associated with the lead.
     */
    public function final_assignation_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'final_assignation_user_id', 'id');
    }
}
