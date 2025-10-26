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

    // Timestamps disabled (only has created_at)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'title',
        'content',
        'category',
        'type',
        'created_by',
        'created_at',
    ];

    // Casts for automatic type conversion
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Default attribute values
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
