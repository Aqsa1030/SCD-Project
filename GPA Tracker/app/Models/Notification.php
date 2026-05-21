<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeIcon()
    {
        return match($this->type) {
            'grade' => 'fa-chart-line',
            'attendance' => 'fa-calendar-check',
            'deadline' => 'fa-clock',
            'system' => 'fa-cog',
            'achievement' => 'fa-trophy',
            default => 'fa-bell'
        };
    }

    public function getTypeColorClass()
    {
        return match($this->type) {
            'grade' => 'primary',
            'attendance' => 'warning',
            'deadline' => 'danger',
            'system' => 'info',
            'achievement' => 'success',
            default => 'secondary'
        };
    }
}