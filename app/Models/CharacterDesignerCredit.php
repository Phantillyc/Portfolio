<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterDesignerCredit extends Model {
    use HasFactory;

    protected $fillable = [
        'character_id', 'credit_name', 'credit_url', 'sort_order',
    ];

    public function character() {
        return $this->belongsTo(Character::class, 'character_id');
    }
}
