<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormExam extends Model
{
    use HasFactory;

    protected $table = 'form_exams';

    public function matrials()
    {
        return $this->hasMany(Matrial::class, 'form_exams_id', 'id');
        return $this->hasMany(Question::class, 'form_exams_id', 'id');
    }

    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    protected $fillable = [
        'form_name',
        'type',
        "formula",
        "status",
        "exam_time",
        'writer_id'
    ];
}
