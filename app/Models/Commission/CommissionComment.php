<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionComment extends Model {
    use HasFactory;

    public const AUTHOR_ADMIN = 'admin';
    public const AUTHOR_CLIENT = 'client';
    public const AUTHOR_SYSTEM = 'system';

    public const TYPE_GENERAL = 'general';
    public const TYPE_REVISION_REQUEST = 'revision_request';
    public const TYPE_SYSTEM = 'system';

    protected $fillable = [
        'commission_id', 'author_type', 'author_admin_id', 'author_commissioner_id', 'comment_type', 'body',
    ];

    protected $table = 'commission_comments';

    public function commission() {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function authorCommissioner() {
        return $this->belongsTo(Commissioner::class, 'author_commissioner_id');
    }
}
