<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model {
    use HasFactory;

    protected $fillable = [
        'gallery_item_id', 'image_path', 'caption', 'sort_order', 'is_final_from_commission',
    ];

    protected $casts = [
        'is_final_from_commission' => 'boolean',
    ];

    public function galleryItem() {
        return $this->belongsTo(GalleryItem::class, 'gallery_item_id');
    }
}
