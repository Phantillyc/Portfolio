<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionUpdateImage extends Model {
    use HasFactory;

    protected $fillable = [
        'commission_id', 'title', 'image_path', 'sort',
    ];

    protected $table = 'commission_update_images';

    protected $with = [
        'characters',
    ];

    public function commission() {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function characters() {
        return $this->hasMany(CommissionUpdateImageCharacter::class, 'commission_update_image_id');
    }

    public function getImageUrlAttribute() {
        return url('storage/'.$this->image_path);
    }
}
