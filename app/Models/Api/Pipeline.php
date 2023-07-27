<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pipeline extends Model
{
    //use HasFactory;

    protected $fillable = ['account_id', 'name', 'is_default', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(Pipeline $pipeline){
            $pipeline->created_user_id = auth()->id();
        });
    }

     ////////////RELATIONSHIPS
    /**
     * Get the stages for the pipeline.
     */
    public function stages(): HasMany
    {
        return $this->hasMany(PipelineStage::class, 'pipeline_id', 'id');
    }

    /**
     * Get the account for the pipeline.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
