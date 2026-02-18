<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhoneModel extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'description',
        'display_size',
        'display_type',
        'processor',
        'ram',
        'camera',
        'battery',
        'os',
        'dimensions',
        'weight',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
