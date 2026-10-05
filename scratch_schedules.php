<?php
$teams = App\Models\team::all();
foreach($teams as $team) {
    if(rand(0, 1) === 1) {
        App\Models\Schedule::create([
            'team_id' => $team->id,
            'date' => \Carbon\Carbon::today()->addDays(rand(1, 14))->format('Y-m-d'),
            'hour' => rand(9, 20),
            'title' => '練習試合相手募集',
            'note' => '市民体育館で行います。よろしくお願いします。'
        ]);
    }
}
echo "Schedules created successfully.\n";
