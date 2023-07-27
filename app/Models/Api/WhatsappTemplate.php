<?php

namespace App\Models\Api;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappTemplate extends Model
{
    //use HasFactory;
    protected $fillable = ['template_name', 'dynamic_index', 'replace_type', 'table_name', 'table_column', 'raw_value'];
}
