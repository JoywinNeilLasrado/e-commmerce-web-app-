<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'phone_model_id',
        'condition_id',
        'title',
        'slug',
        'description',
        'primary_image',
        'base_price',
        'original_price',
        'storage',
        'color',
        'price',
        'stock',
        'sku',
        'is_available',
        'imei',
        'warranty_months',
        'whats_in_box',
        'views',
        'is_featured',
        'is_active',
        'published_at'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_available' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function phoneModel(): BelongsTo
    {
        return $this->belongsTo(PhoneModel::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function inWishlist(): bool
    {
        if (!auth()->check()) return false;
        return $this->wishlists()->where('user_id', auth()->id())->exists();
    }

    // Check if in stock
    public function inStock(): bool
    {
        return $this->stock > 0 && $this->is_available;
    }

    // Get discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round(( ($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    // Get average rating
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->where('is_approved', true)->avg('rating') ?? 0, 1);
    }

    // Get primary image URL
    public function getPrimaryImageUrlAttribute(): string
    {
        if (!$this->primary_image) {
            return 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=800';
        }

        if (str_starts_with($this->primary_image, 'http')) {
            return $this->primary_image;
        }

        return asset('storage/' . $this->primary_image);
    }
}
