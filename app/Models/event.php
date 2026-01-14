<?php

// app/Models/Event.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'content', 'thumbnail'
    ];

    public static function list()
    {
        return static::latest()->paginate(10);
    }

    public static function storeData($data)
    {
        return static::create($data);
    }

    public function updateData($data)
    {
        return $this->update($data);
    }
}
