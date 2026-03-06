<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportPage extends Model
{
    protected $fillable = ['slug', 'title', 'content', 'meta_description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }
}
