<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantImage extends Model
{
    protected $fillable = ['variant_id','image_path'];

    public function variant()
    {
        return $this->belongsTo(\App\Models\ProductVariant::class,'variant_id');
    }
}
