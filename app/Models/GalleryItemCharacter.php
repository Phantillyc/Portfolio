<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItemCharacter extends Model {
    use HasFactory;

    protected $fillable = [
        'gallery_item_id', 'character_id',
    ];

    public function galleryItem() {
        return $this->belongsTo(GalleryItem::class, 'gallery_item_id');
    }

    public function character() {
        return $this->belongsTo(Character::class, 'character_id');
    }
}
