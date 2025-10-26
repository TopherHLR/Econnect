<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'password_reset_tokens';

    // Primary key
    protected $primaryKey = 'email';

    // The primary key is a string (not auto-incrementing)
    public $incrementing = false;

    // Primary key type
    protected $keyType = 'string';

    // No automatic timestamps
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    // Casts for automatic data conversion
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
