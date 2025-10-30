<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLibrary extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'user_libraries';

    // Primary key
    protected $primaryKey = 'id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // Disable timestamps (no created_at, updated_at)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'library_id',
        'saved_at',
    ];

    // Type casting
    protected $casts = [
        'saved_at' => 'datetime',
    ];

    /**
     * Relationship: A saved library belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relationship: A saved library belongs to an eco library entry.
     */
    public function ecoLibrary()
    {
        return $this->belongsTo(EcoLibrary::class, 'library_id', 'library_id');
    }
}
