<?php

namespace App\Models\Commission;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CommissionClient extends Authenticatable {
    protected $fillable = [
        'username', 'password', 'is_active', 'remember_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
