<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionImageProgressEntry extends Model {
    use HasFactory;

    public const STAGE_SKETCH = 'sketch';
    public const STAGE_LINEART = 'lineart';
    public const STAGE_COLOR = 'color';
    public const STAGE_SHADING = 'shading';
    public const STAGE_OTHER = 'other';

    protected $fillable = [
        'commission_image_id', 'stage', 'title', 'image_path', 'uploaded_by_admin_id',
    ];

    protected $table = 'commission_image_progress_entries';

    public function commissionImage() {
        return $this->belongsTo(CommissionImage::class, 'commission_image_id');
    }
}
