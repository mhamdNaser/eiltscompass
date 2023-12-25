<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examing extends Model
{
    use HasFactory;

    public function formExam()
    {
        return $this->belongsTo(FormExam::class, 'form_exams_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function student_answers()
    {
        return $this->hasMany(StudentAnswer::class, 'student_examing_id');
    }

    protected $fillable = [
        'student_id',
        'form_exams_id',
        'correction',
        'result',
        'fullmark'
    ];
}
