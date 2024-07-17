<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isStarted = $user->attendances()->whereDate('start_time', today())->whereNull('end_time')->exists();
        $isEnded = $user->attendances()->whereDate('start_time', today())->whereNotNull('end_time')->exists();
        $hasOngoingRest = $user->rests()->whereDate('rest_start', today())->whereNull('rest_end')->exists();

        return view('index', [
            'isStarted' => $isStarted,
            'isEnded' => $isEnded,
            'hasOngoingRest' => $hasOngoingRest,
        ]);
    }

    public function startTime(Request $request)
    {
        $user = auth()->user();
        $attendance = $user->attendances()->today()->started()->first();

        if (!$attendance) {
            $attendance = $user->attendances()->create([
                'start_time' => Carbon::now(),
            ]);
        }

        return redirect()->route('index');
    }

    public function endTime(Request $request)
    {
        $user = auth()->user();
        $attendance = $user->attendances()->today()->started()->whereNull('end_time')->first();

        if (!$attendance) {
            return redirect()->route('index');
        }

        if ($attendance->rests()->whereNull('rest_end')->exists()) {
            return redirect()->route('index');
        }

        $attendance->update([
            'end_time' => Carbon::now(),
        ]);

        return redirect()->route('index');
    }


    public function restStart(Request $request)
    {
        $user = auth()->user();
        $attendance = $user->attendances()->whereDate('start_time', today())->whereNull('end_time')->first();
        $attendance->rests()->create([
            'rest_start' => Carbon::now(),
        ]);

        return redirect()->route('index');
    }

    public function restEnd(Request $request)
    {
        $user = auth()->user();
        $rest = $user->rests()->whereDate('rest_start', today())->whereNull('rest_end')->first();
        $rest->update([
            'rest_end' => Carbon::now(),
        ]);

        return redirect()->route('index');
    }

    public function attendanceList(Request $request)
    {
        $today = Carbon::today();
        $yesterday = $today->copy()->subDay();
        $tomorrow = $today->copy()->addDay();

        $attendances = auth()->user()->attendances()->whereDate('start_time', today())->get();
        
        return view('attendance', [
            'today' => $today,
            'yesterday' => $yesterday,
            'tomorrow' => $tomorrow,
            'attendances' => $attendances,
        ]);
    }
}
