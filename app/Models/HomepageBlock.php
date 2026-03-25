<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageBlock extends Model {
    use HasFactory;

    protected $fillable = [
        'machine_key', 'title', 'content_richtext', 'sort_order', 'is_enabled', 'updated_by_admin_id',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];
}
