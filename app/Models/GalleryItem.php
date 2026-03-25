<?php

namespace App\Models;

use App\Models\Commission\Commission;
use App\Models\Commission\CommissionImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model {
    use HasFactory;

    public const SOURCE_PORTFOLIO = 'portfolio';
    public const SOURCE_COMMISSION = 'commission';

    protected $fillable = [
        'slug', 'title', 'description_richtext', 'source_type', 'source_commission_id', 'source_commission_image_id',
        'is_published', 'published_at', 'cover_image_id', 'created_by_admin_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function sourceCommission() {
        return $this->belongsTo(Commission::class, 'source_commission_id');
    }

    public function sourceCommissionImage() {
        return $this->belongsTo(CommissionImage::class, 'source_commission_image_id');
    }

    public function images() {
        return $this->hasMany(GalleryImage::class, 'gallery_item_id')->orderBy('sort_order')->orderBy('id');
    }

    public function coverImage() {
        return $this->belongsTo(GalleryImage::class, 'cover_image_id');
    }

    public function characters() {
        return $this->belongsToMany(Character::class, 'gallery_item_characters', 'gallery_item_id', 'character_id');
    }

    public function characterLinks() {
        return $this->hasMany(GalleryItemCharacter::class, 'gallery_item_id');
    }
}
