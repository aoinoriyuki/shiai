<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\team;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(team $team)
    {
        // チームに関連するスケジュールを取得する
        // 日付ごとにグループ化
        $schedulesByDate = $team->schedules()->orderBy("date")->orderBy("hour")->get()->groupBy("date");
        return view('team.schedules.index', compact('team', 'schedulesByDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, team $team)
    {
        $selectedDate = $request->query('date', Carbon::today()->format('Y-m-d'));

        
        $existingSchedules = $team->schedules()
            ->whereDate('date', $selectedDate)
            ->get()
            ->keyBy('hour');

        $hours = range(0, 23);

        return view('team.schedules.create', compact('team', 'selectedDate', 'existingSchedules', 'hours'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, team $team)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'hours' => ['required', 'array', 'min:1'],
            'hours.*' => ['integer', 'between:0,23'],
        ], [
            'hours.required' => '登録する時間枠を少なくとも1つ選択してください。',
        ]);
        $date = $validated['date'];
        foreach ($validated['hours'] as $hour) {
            $team->schedules()->firstOrCreate(
                [
                    'date' => $date,
                    'hour' => $hour,
                ],
                [
                    'status' => 'open', 
                ]
            );
        }

        return redirect()
            ->route('team.schedules.index', ['team' => $team, 'date' => $date])
            ->with('status', count($validated['hours']) . '件の時間枠を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(team $team, Schedule $schedule)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(team $team, Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, team $team, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(team $team, Schedule $schedule)
    {
        //
    }
}
