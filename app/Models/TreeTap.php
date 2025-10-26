<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeTap extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'tree_taps';

    // Primary key
    protected $primaryKey = 'tap_id';

    // Auto-incrementing
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // Timestamps (only created_at is present)
    public $timestamps = false;

    // Fillable columns
    protected $fillable = [
        'user_id',
        'tap_date',
        'daily_limit_reached',
        'tap_count',
        'points_earned',
        'created_at',
    ];

    // Casts for automatic data conversion
    protected $casts = [
        'tap_date' => 'date',
        'daily_limit_reached' => 'boolean',
        'tap_count' => 'integer',
        'points_earned' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: TreeTap belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
