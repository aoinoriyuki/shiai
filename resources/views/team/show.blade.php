<x-layouts.app :title="__('チーム詳細')">
    <div class="max-w-4xl mx-auto p-6 space-y-6">

        {{-- ヘッダー --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                {{ $team->team_name }} の詳細
            </h2>
            <a href="{{ route('team.search') }}" class="text-sm text-zinc-500 hover:underline">
                ← 検索結果に戻る
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- チーム情報 --}}
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">チーム名</h3>
                    <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $team->team_name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">種目</h3>
                    <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $team->event }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">連絡先</h3>
                    <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $team->contact }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">練習場所</h3>
                    <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        緯度: {{ $team->latitude }}, 経度: {{ $team->longitude }}
                    </p>
                </div>
            </div>
        </div>

        {{-- スケジュール一覧 --}}
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">
                募集している予定・スケジュール
            </h3>
            
            @if($team->schedules && $team->schedules->count() > 0)
                <div class="space-y-4">
                    @php
                        $myTeam = auth()->user()->team;
                        $mySchedules = collect();
                        if ($myTeam) {
                            $mySchedules = $myTeam->schedules()->where('status', 'open')->get()->map(function($s) {
                                return $s->date . '_' . $s->hour;
                            });
                        }
                    @endphp
                    @foreach($team->schedules()->where('status', 'open')->orderBy('date')->orderBy('hour')->get() as $schedule)
                        <div class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50">
                            <div>
                                <p class="font-bold text-blue-600 dark:text-blue-400 text-lg">
                                    {{ \Carbon\Carbon::parse($schedule->date)->isoFormat('YYYY年M月D日 (ddd)') }} 
                                    {{ sprintf('%02d:00 - %02d:00', $schedule->hour, ($schedule->hour + 1) % 24) }}
                                </p>
                                @if($schedule->title)
                                    <p class="text-zinc-800 dark:text-zinc-200 font-semibold mt-1">{{ $schedule->title }}</p>
                                @endif
                                @if($schedule->note)
                                    <p class="text-zinc-600 dark:text-zinc-400 text-sm mt-1">{{ $schedule->note }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('team.schedules.show', [$team, $schedule]) }}" class="px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded text-sm font-medium transition">
                                    詳細
                                </a>

                                @if($myTeam && $mySchedules->contains($schedule->date . '_' . $schedule->hour))
                                    <form method="POST" action="{{ route('team.match', $team) }}">
                                        @csrf
                                        <input type="hidden" name="date" value="{{ $schedule->date }}">
                                        <input type="hidden" name="hour" value="{{ $schedule->hour }}">
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm font-bold transition">
                                            即時マッチング！
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-zinc-500 dark:text-zinc-400">現在登録されている予定はありません。</p>
            @endif
        </div>

    </div>
</x-layouts.app>
