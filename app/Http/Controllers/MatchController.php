<?php

namespace App\Http\Controllers;

use App\Models\team;
use App\Models\TeamMatch;
use App\Models\Schedule;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function store(Request $request, team $team)
    {
        $hostTeam = $team;
        $guestTeam = auth()->user()->team;
        $date = $request->input('date');
        $hour = $request->input('hour');

        if (!$guestTeam) {
            return redirect()->back()->with('error', '自分のチームを登録してください。');
        }

        // ホストとゲストのスケジュールが存在し、かつオープン状態か確認
        $hostSchedule = $hostTeam->schedules()->where('date', $date)->where('hour', $hour)->where('status', 'open')->first();
        $guestSchedule = $guestTeam->schedules()->where('date', $date)->where('hour', $hour)->where('status', 'open')->first();

        if (!$hostSchedule) {
            return redirect()->back()->with('error', '相手チームの予定が存在しません。');
        }
        
        if (!$guestSchedule) {
            return redirect()->back()->with('error', '自分のチームの同じ日時の予定が存在しません。先に予定を作成してください。');
        }

        // スケジュールのステータスを更新
        $hostSchedule->update(['status' => 'matched']);
        $guestSchedule->update(['status' => 'matched']);

        // マッチングレコードを作成
        TeamMatch::create([
            'host_team_id' => $hostTeam->id,
            'guest_team_id' => $guestTeam->id,
            'date' => $date,
            'hour' => $hour,
        ]);

        return redirect()->route('team.show', $hostTeam)->with('success', 'マッチングが成立しました！');
    }
}
