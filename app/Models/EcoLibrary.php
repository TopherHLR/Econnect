<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoLibrary extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'eco_library';

    // Primary key
    protected $primaryKey = 'library_id';

    // Auto-incrementing ID
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // Disable timestamps (only has created_at)
    public $timestamps = false;

    protected $fillable = [
        'title',
        'content',
        'category',
        'type',
        'source_link',
        'image',        // ✅ new
        'created_by',
        'created_at',
    ];

    // Type casting
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Default attributes
    protected $attributes = [
        'type' => 'Tip',
    ];

    /**
     * Relationship: Each library entry is created by a user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
