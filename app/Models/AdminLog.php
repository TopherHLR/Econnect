<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    // Table name (if not following Laravel naming convention)
    protected $table = 'admin_logs';

    // Primary key
    protected $primaryKey = 'log_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Primary key data type
    protected $keyType = 'int';

    // Timestamps (you only have created_at, so disable automatic timestamps)
    public $timestamps = false;

    // Fillable fields for mass assignment
    protected $fillable = [
        'admin_id',
        'action_type',
        'description',
        'created_at',
    ];

    // Casts for automatic data conversion
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: each log belongs to an admin user.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }
}
