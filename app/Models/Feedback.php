<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'feedback';

    // Primary key
    protected $primaryKey = 'feedback_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Primary key data type
    protected $keyType = 'int';

    // Timestamps disabled (only created_at exists)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'content',
        'rating',
        'created_at',
    ];

    // Casts
    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: Feedback belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
