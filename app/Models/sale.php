<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sale extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'thumbnail',
    ];

    /* =====================
        QUERY
    ====================== */
    public static function list()
    {
        return static::latest()->paginate(10);
    }

    /* =====================
        STORE
    ====================== */
    public static function storeData(array $data)
    {
        return static::create($data);
    }

    /* =====================
        UPDATE
    ====================== */
    public function updateData(array $data)
    {
        // xóa ảnh cũ nếu có ảnh mới
        if (
            isset($data['thumbnail']) &&
            $this->thumbnail &&
            Storage::disk('public')->exists($this->thumbnail)
        ) {
            Storage::disk('public')->delete($this->thumbnail);
        }

        return $this->update($data);
    }

    /* =====================
        DELETE
    ====================== */
    public function deleteData()
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            Storage::disk('public')->delete($this->thumbnail);
        }

        return $this->delete();
    }
}
