<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionManualPermission extends Model {
    use HasFactory;

    protected $fillable = [
        'commissioner_id', 'granted_by_admin_id', 'is_consumed', 'consumed_at',
    ];

    protected $casts = [
        'is_consumed' => 'boolean',
        'consumed_at' => 'datetime',
    ];

    protected $table = 'commission_manual_permissions';

    public function commissioner() {
        return $this->belongsTo(Commissioner::class, 'commissioner_id');
    }
}
