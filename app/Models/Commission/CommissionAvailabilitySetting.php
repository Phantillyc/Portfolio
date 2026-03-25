<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionAvailabilitySetting extends Model {
    use HasFactory;

    public const STATE_OPEN = 'open';
    public const STATE_CLOSED = 'closed';
    public const STATE_MANUAL = 'manual';

    protected $fillable = [
        'state', 'open_richtext', 'closed_richtext', 'manual_richtext', 'updated_by_admin_id',
    ];
}
