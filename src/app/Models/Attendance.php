<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
    ];

    protected $dates = [
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('start_time', today());
    }

    public function scopeStarted($query)
    {
        return $query->whereNotNull('start_time')->whereNull('end_time');
    }

    public function scopeEnded($query)
    {
        return $query->whereNotNull('start_time')->whereNotNull('end_time');
    }

    public function getDuration()
    {
        if ($this->start_time && $this->end_time) {
            return $this->end_time->diff($this->start_time);
        } else {
            return null;
        }
    }
}
