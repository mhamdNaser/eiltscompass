<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    protected $fillable = [
        'stu_ans_value',
        'answer_id',
        'student_examing_id',
        'answer_content'
    ];
}
