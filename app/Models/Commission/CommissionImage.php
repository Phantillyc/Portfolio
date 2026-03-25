<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionImage extends Model {
    use HasFactory;

    public const STATE_NOT_STARTED = 'not_started';
    public const STATE_SKETCH_DONE = 'sketch_done';
    public const STATE_LINEART_DONE = 'lineart_done';
    public const STATE_COLOR_DONE = 'color_done';
    public const STATE_SHADING_DONE = 'shading_done';
    public const STATE_PENDING_APPROVAL = 'pending_approval';
    public const STATE_REVISION_REQUESTED = 'revision_requested';
    public const STATE_APPROVED = 'approved';

    protected $fillable = [
        'commission_id', 'image_index', 'title', 'state', 'marked_complete_at', 'approved_at',
    ];

    protected $casts = [
        'marked_complete_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected $table = 'commission_images';

    public function commission() {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function progressEntries() {
        return $this->hasMany(CommissionImageProgressEntry::class, 'commission_image_id')->orderBy('created_at')->orderBy('id');
    }

    public function characterAssignments() {
        return $this->hasMany(CommissionImageAssignment::class, 'commission_image_id');
    }

    public function requestCharacters() {
        return $this->belongsToMany(CommissionRequestCharacter::class, 'commission_image_assignments', 'commission_image_id', 'commission_request_character_id');
    }

    public function publication() {
        return $this->hasOne(CommissionGalleryPublication::class, 'commission_image_id');
    }
}
