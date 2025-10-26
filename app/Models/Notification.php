<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'notifications';

    // Primary key
    protected $primaryKey = 'notification_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // No timestamps (only has created_at)
    public $timestamps = false;

    // Fillable columns
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
        'created_at',
    ];

    // Casts
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Default values
    protected $attributes = [
        'is_read' => 0,
    ];

    /**
     * Relationship: A notification belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
