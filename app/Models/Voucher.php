<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'vouchers';

    // Primary key
    protected $primaryKey = 'voucher_id';

    // Auto-incrementing
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // No timestamps (no created_at or updated_at)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'title',
        'description',
        'required_points',
        'discount_value',
        'expiry_date',
        'is_active',
        'created_by',
    ];

    // Casts for type handling
    protected $casts = [
        'required_points' => 'integer',
        'is_active' => 'boolean',
        'expiry_date' => 'date',
    ];

    /**
     * Relationship: Voucher created by an admin or user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    /**
     * Relationship: Voucher can be redeemed by multiple users.
     */
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class, 'voucher_id', 'voucher_id');
    }
}
