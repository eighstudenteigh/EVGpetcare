<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClosedDay;
use Carbon\Carbon;

class ClosedDaysController extends Controller{

    public function index()
{
    try {
        $closedDays = ClosedDay::all()->map(function ($closedDay) {
            return [
                'title' => 'Closed',
                'start' => Carbon::parse($closedDay->date)->format('Y-m-d'),
                'allDay' => true
            ];
        })->toArray();

        return response()->json($closedDays);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch closed days'], 500);
    }
}

public function store(Request $request)
{
    try {
        $request->validate(['date' => 'required|date|unique:closed_days,date']);
        ClosedDay::create(['date' => $request->date]);

        return response()->json(['message' => 'Day closed successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to close the day. ' . $e->getMessage()], 500);
    }
}

public function destroy($date)
{
    try {
        $deleted = ClosedDay::whereDate('date', $date)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Day re-enabled successfully']);
        } else {
            return response()->json(['error' => 'Date not found or already enabled'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to re-enable the day. ' . $e->getMessage()], 500);
    }
}


    // Get all weekend days dynamically for the current month
    private function getWeekendDays()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $weekends = [];

        for ($day = 1; $day <= 31; $day++) {
            $date = Carbon::createFromDate($currentYear, $currentMonth, $day);
            if ($date->isWeekend()) {
                $weekends[] = $date->format('Y-m-d');
            }
        }

        return $weekends;
    }
}
