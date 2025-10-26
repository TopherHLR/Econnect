<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'quests';

    // Primary key
    protected $primaryKey = 'quest_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // No default timestamps (no created_at or updated_at)
    public $timestamps = false;

    // Fillable columns
    protected $fillable = [
        'title',
        'description',
        'category',
        'points_reward',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    // Casts for automatic type conversion
    protected $casts = [
        'points_reward' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Default attribute values
    protected $attributes = [
        'category' => 'General Sustainability',
        'status' => 'active',
    ];

    /**
     * Relationship: Quest is created by a user (admin/seller)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    /**
     * Relationship: Quest can have many submissions.
     */
    public function submissions()
    {
        return $this->hasMany(QuestSubmission::class, 'quest_id', 'quest_id');
    }
}
