<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProspectingSource extends Model
{
    //use HasFactory;
    protected $fillable = ['account_id', 'description', 'prospecting_source_id'];

    protected $with = ['prospecting_means'];

    ////////////RELATIONSHIPS
    /**
     * Get the mediums for the client origin.
     */
    public function prospecting_means(): HasMany
    {
        return $this->hasMany(ProspectingSource::class, 'prospecting_source_id', 'id');
    }

    /**
     * Get the origin for the origin medium.
     */
    public function prospecting_source(): BelongsTo
    {
        return $this->belongsTo(ProspectingSource::class, 'prospecting_source_id', 'id');
    }
}
