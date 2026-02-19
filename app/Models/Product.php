<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'phone_model_id',
        'title',
        'slug',
        'description',
        'primary_image',
        'base_price',
        'original_price',
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
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function phoneModel(): BelongsTo
    {
        return $this->belongsTo(PhoneModel::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
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

    // Get available variants only
    public function availableVariants(): HasMany
    {
        return $this->variants()->where('is_available', true)->where('stock', '>', 0);
    }

    // Get minimum price from variants
    public function getMinPriceAttribute()
    {
        return $this->variants()->min('price');
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
