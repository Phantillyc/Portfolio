<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionUpdateImageCharacter extends Model {
    use HasFactory;

    protected $fillable = [
        'commission_update_image_id', 'name', 'reference_url',
    ];

    protected $table = 'commission_update_image_characters';

    public function image() {
        return $this->belongsTo(CommissionUpdateImage::class, 'commission_update_image_id');
    }
}
