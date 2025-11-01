<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoAction extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'eco_actions';

    // Primary key
    protected $primaryKey = 'action_id';

    // Auto-incrementing integer primary key
    public $incrementing = true;

    // Primary key data type
    protected $keyType = 'int';

    // No timestamps specified in the schema
    public $timestamps = false;
    // If your table doesn’t have updated_at
    public const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'description',
        'category',
        'type', // ✅ Add this
        'is_active',
        'points_value',
        'image',        // ✅ new
        'created_by',
        'created_at'
    ];

    // Casts for automatic type conversion
    protected $casts = [
        'is_active' => 'boolean',
        'points_value' => 'integer',
    ];

    // Default values
    protected $attributes = [
        'is_active' => 1,
        'points_value' => 1,
    ];


    /**
     * Relationship: each action is created by a user (admin or seller)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
