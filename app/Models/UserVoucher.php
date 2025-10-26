<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'user_vouchers';

    // Primary key
    protected $primaryKey = 'redemption_id';

    // Auto-incrementing
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // No default timestamps (no created_at or updated_at)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'redeem_points_cost',
        'user_id',
        'voucher_id',
        'voucher_code',
        'qr_code',
        'redeemed_date',
        'status',
    ];

    // Casts for proper data handling
    protected $casts = [
        'redeem_points_cost' => 'integer',
        'redeemed_date' => 'datetime',
    ];

    /**
     * Relationship: Voucher redemption belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relationship: Voucher redemption is linked to a voucher.
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id', 'voucher_id');
    }
}
