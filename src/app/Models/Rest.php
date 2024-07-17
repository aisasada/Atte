<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'rest_start',
        'rest_end',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function getDuration()
    {
        if ($this->rest_end) {
            return Carbon::parse($this->rest_end)->diff(Carbon::parse($this->rest_start));
        } else {
            return null;
        }
    }
}