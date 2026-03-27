<?php

namespace App\Models\Commission;

use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionGalleryPublication extends Model {
    use HasFactory;

    protected $fillable = [
        'commission_image_id', 'gallery_item_id', 'created_by_admin_id', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $table = 'commission_gallery_publications';

    public function commissionImage() {
        return $this->belongsTo(CommissionImage::class, 'commission_image_id');
    }

    public function galleryItem() {
        return $this->belongsTo(GalleryItem::class, 'gallery_item_id');
    }
}
