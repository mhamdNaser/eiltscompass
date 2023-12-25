<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    use HasFactory;

    public function userPayment()
    {
        return $this->belongsTo(User::class, 'UsePayment_id');
    }

    protected $fillable = [
        'created_at',
        'UsePayment_id',
        'UsePayment_value',
        'time_expired'
    ];

    // Accessor for time_expired
    public function getTimeExpiredAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}
