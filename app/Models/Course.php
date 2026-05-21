<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'code',
        'name',
        'credits',
        'instructor',
        'instructor_email',
        'schedule',
        'room',
        'target_grade',
        'color_code',
        'description',
        'notes',
        'textbook',
        'current_grade',
        'status',
    ];

    /**
     * Relationships
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Accessors for backward compatibility
     */
    public function getCourseCodeAttribute()
    {
        return $this->code;
    }

    public function getCourseNameAttribute()
    {
        return $this->name;
    }

    public function getCreditHoursAttribute()
    {
        return $this->credits;
    }

    /**
     * Get attendance percentage - ACCESSOR
     */
    public function getAttendancePercentageAttribute()
    {
        return $this->calculateAttendancePercentage();
    }

    /**
     * Calculate attendance percentage
     */
    public function calculateAttendancePercentage()
    {
        $total = $this->attendances->count();
        
        if ($total == 0) {
            return 0;
        }
        
        $present = $this->attendances->where('status', 'present')->count();
        
        return round(($present / $total) * 100, 1);
    }

    /**
     * Calculate current grade based on all graded assessments
     */
    public function calculateCurrentGrade()
    {
        // Get all graded assessments
        $gradedAssessments = $this->grades()
            ->where('status', 'graded')
            ->whereNotNull('marks_obtained')
            ->whereNotNull('total_marks')
            ->get();
        
        if ($gradedAssessments->count() == 0) {
            return null;
        }
        
        // Calculate weighted average
        $totalWeightage = 0;
        $weightedSum = 0;
        
        foreach ($gradedAssessments as $grade) {
            $percentage = ($grade->marks_obtained / $grade->total_marks) * 100;
            $weightedScore = ($percentage * $grade->weightage) / 100;
            
            $weightedSum += $weightedScore;
            $totalWeightage += $grade->weightage;
        }
        
        // If total weightage is 0, return average percentage
        if ($totalWeightage == 0) {
            $averagePercentage = $gradedAssessments->avg(function($grade) {
                return ($grade->marks_obtained / $grade->total_marks) * 100;
            });
            return round($averagePercentage, 2);
        }
        
        // Calculate final grade
        $currentGrade = ($weightedSum / $totalWeightage) * 100;
        
        // Update the course's current_grade field
        $this->current_grade = round($currentGrade, 2);
        $this->save();
        
        return round($currentGrade, 2);
    }

    /**
     * Get letter grade
     */
    public function getLetterGrade()
    {
        if (!$this->current_grade) {
            return 'N/A';
        }

        $grade = $this->current_grade;
        
        if ($grade >= 90) return 'A+';
        if ($grade >= 85) return 'A';
        if ($grade >= 80) return 'A-';
        if ($grade >= 75) return 'B+';
        if ($grade >= 70) return 'B';
        if ($grade >= 65) return 'B-';
        if ($grade >= 60) return 'C+';
        if ($grade >= 55) return 'C';
        if ($grade >= 50) return 'C-';
        if ($grade >= 45) return 'D';
        
        return 'F';
    }

    /**
     * Get grade point (4.0 scale) based on current grade
     */
    public function getGradePoint()
    {
        if (!$this->current_grade) {
            return 0;
        }

        $grade = $this->current_grade;
        
        // 4.0 GPA Scale
        if ($grade >= 90) return 4.0;  // A+
        if ($grade >= 85) return 4.0;  // A
        if ($grade >= 80) return 3.7;  // A-
        if ($grade >= 75) return 3.3;  // B+
        if ($grade >= 70) return 3.0;  // B
        if ($grade >= 65) return 2.7;  // B-
        if ($grade >= 60) return 2.3;  // C+
        if ($grade >= 55) return 2.0;  // C
        if ($grade >= 50) return 1.7;  // C-
        if ($grade >= 45) return 1.0;  // D
        
        return 0.0; // F
    }

    /**
     * Get pending assignments count
     */
    public function getPendingAssignments()
    {
        return $this->grades()
            ->whereIn('status', ['pending', 'assigned'])
            ->count();
    }

    /**
     * Get grade color class
     */
    public function getGradeColorClass()
    {
        if (!$this->current_grade) {
            return 'default';
        }

        if ($this->current_grade >= 80) return 'success';
        if ($this->current_grade >= 60) return 'warning';
        return 'danger';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status ?? 'active') {
            'active' => 'success',
            'completed' => 'primary',
            'dropped' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIcon()
    {
        return match($this->status ?? 'active') {
            'active' => 'fa-check-circle',
            'completed' => 'fa-flag-checkered',
            'dropped' => 'fa-times-circle',
            default => 'fa-circle'
        };
    }
}