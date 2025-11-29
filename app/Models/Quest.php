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
    public function getRouteKeyName()
    {
        return 'quest_id';
    }

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
         'required_points',  // new
    ];


    // Casts for automatic type conversion
    protected $casts = [
        'points_reward' => 'integer',
    'start_date' => 'datetime:Y-m-d',
    'end_date' => 'datetime:Y-m-d',


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
    protected $appends = [
        'start_date_formatted',
        'end_date_formatted',
    ];

    public function getStartDateFormattedAttribute()
    {
        return $this->start_date ? $this->start_date->format('Y-m-d') : null;
    }

    public function getEndDateFormattedAttribute()
    {
        return $this->end_date ? $this->end_date->format('Y-m-d') : null;
    }

}
