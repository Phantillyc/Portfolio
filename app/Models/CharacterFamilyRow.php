<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterFamilyRow extends Model {
    use HasFactory;

    protected $fillable = [
        'character_id', 'group_label', 'row_order', 'relative_name', 'relative_name_url', 'relative_breed', 'relative_breed_url', 'notes',
    ];

    public function character() {
        return $this->belongsTo(Character::class, 'character_id');
    }
}
