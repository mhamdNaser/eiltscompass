<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormExam extends Model
{
    use HasFactory;

    protected $table = 'form_exams';

    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'form_exams_id', 'id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'form_exams_id', 'id');
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