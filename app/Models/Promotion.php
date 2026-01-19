<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'start_at',
        'end_at',
        'is_active'
    ];

    // ✅ FIX LỖI format() – BẮT BUỘC
    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'is_active'=> 'boolean',
    ];

    /* ================= RELATIONS ================= */

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /* ================= LOGIC ================= */

    // Khuyến mãi còn hiệu lực?
    public function isValid()
    {
        $now = now();

        return $this->is_active
            && (!$this->start_at || $this->start_at <= $now)
            && (!$this->end_at || $this->end_at >= $now);
    }

    // Áp dụng giảm giá
    public function apply($price)
    {
        if ($this->type === 'percent') {
            return max($price - ($price * $this->value / 100), 0);
        }

        return max($price - $this->value, 0);
    }
}
