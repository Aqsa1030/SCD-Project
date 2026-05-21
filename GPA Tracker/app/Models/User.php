<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verification_token',
        'email_verified_at',
        'password_reset_token',
        'password_reset_expires',
        'verified_by_admin_at',
        'verified_by_admin_id',
        'profile_image',
        'phone',
        'student_id',
        'bio',
        'degree',
        'department',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
        'password_reset_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_by_admin_at' => 'datetime',
            'password_reset_expires' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is verified by admin
     */
    public function isVerifiedByAdmin()
    {
        return !is_null($this->verified_by_admin_at);
    }

    /**
     * Get profile image URL
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=667eea&color=ffffff&bold=true';
    }

    /**
     * Relationships
     */
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function verifiedByAdmin()
    {
        return $this->belongsTo(User::class, 'verified_by_admin_id');
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, Semester::class);
    }
}