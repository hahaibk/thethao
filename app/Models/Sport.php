<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sport extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'sort_order',
    ];

    /**
     * Boot model – tự động tạo & cập nhật slug
     */
    protected static function booted()
    {
        // Khi tạo mới
        static::creating(function ($sport) {
            if (empty($sport->slug)) {
                $sport->slug = Str::slug($sport->name);
            }
        });

        // Khi cập nhật
        static::updating(function ($sport) {
            $sport->slug = Str::slug($sport->name);
        });
    }

    /**
     * Quan hệ: 1 sport có nhiều product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
