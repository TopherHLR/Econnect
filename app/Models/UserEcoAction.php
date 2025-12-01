<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEcoAction extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'user_eco_actions';

    // Primary key
    protected $primaryKey = 'log_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // No created_at or updated_at timestamps
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'action_id',
        'log_date',
    ];

    // Type casting for easier handling
    protected $casts = [
        'log_date' => 'date',
    ];

    /**
     * Relationship: A user eco action belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relationship: A user eco action belongs to an eco action.
     */
    public function ecoAction()
    {
        return $this->belongsTo(EcoAction::class, 'action_id', 'action_id');
    }
}
