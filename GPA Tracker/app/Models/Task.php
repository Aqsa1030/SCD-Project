<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'description',
        'due_date',
        'due_time',
        'priority',
        'status',
        'progress',
    ];

    protected $casts = [
        'due_date' => 'date',
        'progress' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isOverdue()
    {
        return $this->due_date < now() && $this->status != 'completed';
    }

    public function getPriorityBadgeClass()
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'completed' => 'success',
            'in_progress' => 'primary',
            'pending' => 'warning',
            default => 'secondary'
        };
    }
}