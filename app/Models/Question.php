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

    public function materials()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function formexam()
    {
        return $this->belongsTo(FormExam::class, 'form_exams_id', 'id');
    }

    protected $fillable = [
        'content',
        'type',
        'points',
        'material_id',
        'form_exams_id',
    ];
}