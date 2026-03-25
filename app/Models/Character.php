<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model {
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'gender', 'age', 'breed', 'bio_richtext',
    ];

    public function designerCredits() {
        return $this->hasMany(CharacterDesignerCredit::class, 'character_id')->orderBy('sort_order')->orderBy('id');
    }

    public function familyRows() {
        return $this->hasMany(CharacterFamilyRow::class, 'character_id')->orderBy('row_order')->orderBy('id');
    }

    public function galleryLinks() {
        return $this->hasMany(GalleryItemCharacter::class, 'character_id');
    }

    public function galleryItems() {
        return $this->belongsToMany(GalleryItem::class, 'gallery_item_characters', 'character_id', 'gallery_item_id');
    }
}
