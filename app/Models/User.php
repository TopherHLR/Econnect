<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'qr_code',
        'user_type',
        'is_verified',
            'is_active', // ← add this
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean', // ← add this
    ];

    /**
     * Relationship: A user has many saved libraries.
     */
    public function savedLibraries()
    {
        return $this->hasMany(UserLibrary::class, 'user_id', 'user_id')->with('ecoLibrary');
    }

    /**
     * Relationship: A user has many saved eco actions.
     */
    public function savedEcoActions()
    {
        return $this->hasMany(UserEcoAction::class, 'user_id', 'user_id')->with('ecoAction');
    }
    public function pointsHistory()
    {
        return $this->hasMany(UserPointsHistory::class, 'user_id', 'user_id');
    }
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class, 'user_id', 'user_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'user_id');
    }
    public function questSubmissions()
    {
        return $this->hasMany(QuestSubmission::class, 'user_id', 'user_id');
    }
}
