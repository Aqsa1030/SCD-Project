<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'year',  // ← ADD THIS
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'year' => 'integer', // ← ADD THIS
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($semester) {
            // Automatically set year from start_date if not provided
            if (!$semester->year && $semester->start_date) {
                $semester->year = date('Y', strtotime($semester->start_date));
            }
        });
        
        static::updating(function ($semester) {
            // Update year if start_date changes
            if ($semester->isDirty('start_date')) {
                $semester->year = date('Y', strtotime($semester->start_date));
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}