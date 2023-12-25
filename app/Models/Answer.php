<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    protected $fillable = [
        'answer_content',
        'matching',
        'answer_value',
        'question_id',
    ];
}
