<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSectionImage extends Model
{
    protected $fillable = ['home_section_id','image_path','sort_order'];

    public function section()
    {
        return $this->belongsTo(HomeSection::class,'home_section_id');
    }
}
