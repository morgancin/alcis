<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityResult extends Model
{
    //use HasFactory;
    protected $fillable = ['activity_type_id', 'name', 'tracking_type'];

    ////////////RELATIONSHIPS
    public function activity_type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id', 'id');
    }
}
