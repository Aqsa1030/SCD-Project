<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'date',
        'status',
        'time',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'late' => 'warning',
            'excused' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusIcon()
    {
        return match($this->status) {
            'present' => 'fa-check-circle',
            'absent' => 'fa-times-circle',
            'late' => 'fa-clock',
            'excused' => 'fa-info-circle',
            default => 'fa-question-circle'
        };
    }
}