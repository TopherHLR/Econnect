<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPointsHistory extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'user_points_history';

    // Primary key
    protected $primaryKey = 'history_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // No timestamps (only created_at exists)
    public $timestamps = false;

    // Fillable columns
    protected $fillable = [
        'user_id',
        'activity_type',
        'source_id',
        'points_change',
        'created_at',
    ];

    // Casts for proper data handling
    protected $casts = [
        'points_change' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: History record belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Optionally link to source models based on activity_type.
     * For example, to dynamically access the related record.
     */
    public function source()
    {
        switch ($this->activity_type) {
            case 'Tree Tap':
                return $this->belongsTo(TreeTap::class, 'source_id', 'tap_id');
            case 'Eco Action':
                return $this->belongsTo(UserEcoAction::class, 'source_id', 'log_id');
            case 'Quest':
                return $this->belongsTo(QuestSubmission::class, 'source_id', 'submission_id');
            default:
                return null;
        }
    }
}
