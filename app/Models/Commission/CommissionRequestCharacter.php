<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionRequestCharacter extends Model {
    use HasFactory;

    protected $fillable = [
        'commission_id', 'character_name', 'reference_url', 'notes', 'sort_order',
    ];

    protected $table = 'commission_request_characters';

    public function commission() {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function imageAssignments() {
        return $this->hasMany(CommissionImageAssignment::class, 'commission_request_character_id');
    }

    public function commissionImages() {
        return $this->belongsToMany(CommissionImage::class, 'commission_image_assignments', 'commission_request_character_id', 'commission_image_id');
    }
}
