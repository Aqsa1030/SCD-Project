<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'assessment_type',
        'title',
        'weightage',
        'marks_obtained',
        'total_marks',
        'date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'weightage' => 'float',
        'marks_obtained' => 'float',
        'total_marks' => 'float',
        'date' => 'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getPercentageAttribute()
    {
        if($this->marks_obtained === null) return null;
        return round(($this->marks_obtained / $this->total_marks) * 100, 2);
    }

    public function getLetterGradeAttribute()
    {
        $percentage = $this->percentage;
        if($percentage === null) return 'N/A';
        
        if($percentage >= 85) return 'A+';
        if($percentage >= 80) return 'A-';
        if($percentage >= 75) return 'B+';
        if($percentage >= 70) return 'B';
        if($percentage >= 65) return 'B-';
        if($percentage >= 60) return 'C';
        if($percentage >= 50) return 'D';
        return 'F';
    }
}