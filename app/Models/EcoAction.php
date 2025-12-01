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
    public const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'description',
        'category',
        'type',
        'image',
        'created_by',
        'created_at',
        'archive', // ✅ added
    ];

    // Type casting
    protected $casts = [
        'created_at' => 'datetime',
        'archive' => 'boolean', // ✅ cast archive as boolean
    ];

    /**
     * Relationship: each action is created by a user (admin or seller)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
