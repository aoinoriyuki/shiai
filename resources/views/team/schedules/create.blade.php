<x-layouts.app :title="__('予定ブロック作成')">
    <div class="max-w-4xl mx-auto p-6 space-y-6">

        {{-- ヘッダー --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                    {{ $team->team_name }} - 時間枠の登録
                </h2>
                <p class="text-sm text-zinc-500">日付を選び、開放したい時間帯のブロックをクリックして選択してください。</p>
            </div>
            <a href="{{ route('team.schedules.index', ['team' => $team, 'date' => $selectedDate]) }}" class="text-sm text-zinc-500 hover:underline">
                ←カレンダーに戻る
            </a>
        </div>

        {{-- エラーメッセージ表示 --}}
        @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- 登録フォーム本体 --}}
        <form method="POST" action="{{ route('team.schedules.store', $team) }}" class="space-y-6">
            @csrf

            {{-- 1. 日付選択（日付を変更すると再読み込みしてその日の空き状況を取得） --}}
            <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <label for="date_picker" class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">対象日時</label>
                    <input type="date" 
                           id="date_picker" 
                           name="date" 
                           value="{{ $selectedDate }}"
                           onchange="location.href='{{ route('team.schedules.create', $team) }}?date=' + this.value"
                           class="border border-zinc-300 dark:border-zinc-600 rounded-lg px-3 py-1.5 text-sm bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500">
                </div>
                <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                    {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('YYYY年M月D日 (ddd)') }}
                </span>
            </div>

            {{-- 2. 0時〜23時のブロック選択グリッド --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                    登録する時間ブロックを選択（複数選択可能）
                </label>

                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-2.5">
                    @foreach ($hours as $hour)
                        @php
                            $isRegistered = $existingSchedules->has($hour);
                            $timeLabel = sprintf('%02d:00 - %02d:00', $hour, ($hour + 1) % 24);
                        @endphp

                        @if ($isRegistered)
                            {{-- すでに登録済みのスロット（選択不可・グレー） --}}
                            <div class="p-3 border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-900/60 rounded-lg opacity-50 cursor-not-allowed text-center">
                                <span class="font-mono text-xs font-bold text-zinc-400 block">{{ $timeLabel }}</span>
                                <span class="text-[10px] text-zinc-500 mt-1 block font-medium">登録済</span>
                            </div>
                        @else
                            {{-- 選択可能な空きスロット（チェックボックスを隠してブロック全体をクリック可能に） --}}
                            <label class="relative block cursor-pointer">
                                <input type="checkbox" 
                                       name="hours[]" 
                                       value="{{ $hour }}" 
                                       class="peer sr-only">
                                
                                <div class="p-3 border rounded-lg text-center transition select-none
                                    border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:border-blue-400
                                    peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-600">
                                    <span class="font-mono text-xs font-bold block peer-checked:text-white text-zinc-700 dark:text-zinc-300">
                                        {{ $timeLabel }}
                                    </span>
                                    <span class="text-[10px] block mt-1 text-zinc-400 peer-checked:text-blue-100">
                                        選択する
                                    </span>
                                </div>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>

           

            {{-- 送信ボタン --}}
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg shadow-sm transition">
                    選択したブロックを一括登録する
                </button>
            </div>
        </form>

    </div>
</x-layouts.app>