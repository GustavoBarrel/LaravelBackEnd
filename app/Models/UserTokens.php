<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTokens extends Model
{
    protected $table = 'user_tokens';

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
        'expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
