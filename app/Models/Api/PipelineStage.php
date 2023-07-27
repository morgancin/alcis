<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PipelineStage extends Model
{
    //use HasFactory;
    protected $fillable = ['pipeline_id', 'name', 'percentage', 'sort_order', 'created_user_id', 'updated_user_id', 'active'];

    protected static function boot(){
        parent::boot();
        self::creating(function(PipelineStage $pipeline_stage){
            $pipeline_stage->created_user_id = auth()->id();
        });
    }

    ////////////RELATIONSHIPS
    /**
     * Get the pipeline for the stage.
     */
    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class, 'pipeline_id', 'id');
    }

    /**
     * Get the prospects for the stage.
     */
    public function prospects(): HasMany
    {
        return $this->hasMany(Prospect::class, 'pipeline_stage_id', 'id');
    }
}
