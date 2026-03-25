<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionImageAssignment extends Model {
    use HasFactory;

    protected $fillable = [
        'commission_image_id', 'commission_request_character_id',
    ];

    protected $table = 'commission_image_assignments';

    public function commissionImage() {
        return $this->belongsTo(CommissionImage::class, 'commission_image_id');
    }

    public function requestCharacter() {
        return $this->belongsTo(CommissionRequestCharacter::class, 'commission_request_character_id');
    }
}
