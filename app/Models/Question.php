<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function studentanswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function formexam()
    {
        return $this->hasMany(FormExam::class);
    }

    protected $fillable = [
        'content',
        'type',
        'points',
        'form_exams_id',
    ];
}
