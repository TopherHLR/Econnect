<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'partners';

    // Primary key
    protected $primaryKey = 'partner_id';

    // Auto-incrementing primary key
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // No timestamps (no created_at or updated_at columns)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'business_name',
        'contact_info',
    ];

    /**
     * Relationship: A partner is associated with a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
