<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = [
        'type', 'title', 'subtitle', 'link', 'is_active', 'image', 'sort_order'
    ];

    // Nếu muốn nhiều ảnh, relation images()
    public function images()
    {
        return $this->hasMany(HomeSectionImage::class,'home_section_id')->orderBy('sort_order');
    }
}
