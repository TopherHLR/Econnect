<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestSubmission extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'quest_submissions';

    // Primary key
    protected $primaryKey = 'submission_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // No default timestamps (custom datetime fields)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'quest_id',
        'proof_link',
        'qr_verified',
        'admin_validated',
        'status',
        'tap_progress', // <-- ADD THIS
        'date_submitted',
        'date_completed',
        'verified_by',
    ];

    // Casts for automatic data type conversion
    protected $casts = [
        'qr_verified' => 'boolean',
        'admin_validated' => 'boolean',
        'date_submitted' => 'datetime',
        'date_completed' => 'datetime',
    ];

    // Default values
    protected $attributes = [
        'qr_verified' => 0,
        'admin_validated' => 0,
        'status' => 'pending',
    ];

    /**
     * Relationship: Submission belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relationship: Submission belongs to a quest.
     */
    public function quest()
    {
        return $this->belongsTo(Quest::class, 'quest_id', 'quest_id');
    }

    /**
     * Relationship: Admin who verified the submission.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }
}
