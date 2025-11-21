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

    // Laravel: timestamps = false (since no updated_at)
    public $timestamps = false;

    // Fillable columns
    protected $fillable = [
        'user_id',
        'from_user_id',
        'type',
        'source_table',
        'source_id',
        'title',
        'message',
        'read_at',
        'created_at',
    ];

    // Casts
    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // Default values
    protected $attributes = [
        'read_at' => null,
    ];

    /**
     * Relationship: Notification belongs to the user it is sent *to*
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relationship: Notification also belongs to the user who sent it
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'user_id');
    }
}
