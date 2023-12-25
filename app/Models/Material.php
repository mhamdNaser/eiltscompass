<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(Question::class, 'material_id', 'id');
    }

    public function materials()
    {
        return $this->belongsTo(FormExam::class, 'form_exams_id', 'id');
    }

    protected $fillable = [
        'title',
        'form_exams_id',
    ];
}