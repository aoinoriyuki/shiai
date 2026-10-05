<x-layouts.app :title="__('予定確認')">
  <div class="p-6 max-w-4xl mx-auto">
    <h2 class="font-semibold text-xl mb-4 text-zinc-900 dark:text-zinc-100">{{ __('予定一覧') }}</h2>
    
    @if(isset($schedulesByDate) && $schedulesByDate->count() > 0)
        @foreach ($schedulesByDate as $date => $schedules)
            <div class="mb-6">
                <h3 class="font-bold text-lg text-zinc-800 dark:text-zinc-200 mb-3 border-b border-zinc-200 dark:border-zinc-700 pb-1">
                    {{ \Carbon\Carbon::parse($date)->isoFormat('YYYY年M月D日 (ddd)') }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($schedules as $schedule)
                        @if($schedule->status === 'matched')
                            <div class="p-4 bg-green-100 dark:bg-green-900/40 rounded-lg border border-green-200 dark:border-green-800">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold text-green-700 dark:text-green-300">
                                        {{ $schedule->hour }}:00 - {{ $schedule->hour + 1 }}:00
                                    </p>
                                    <span class="px-2 py-1 bg-green-200 dark:bg-green-800 text-green-800 dark:text-green-100 text-xs font-bold rounded">
                                        マッチング済み
                                    </span>
                                </div>
                                <div class="mt-2 text-right">
                                    <a href="{{ route('team.schedules.show', [$team, $schedule]) }}" class="text-green-600 dark:text-green-400 hover:underline text-sm font-medium">詳細を見る</a>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg border border-transparent">
                                <p class="font-bold text-zinc-700 dark:text-zinc-300">
                                    {{ $schedule->hour }}:00 - {{ $schedule->hour + 1 }}:00
                                </p>
                                <div class="mt-2 text-right">
                                    <a href="{{ route('team.schedules.show', [$team, $schedule]) }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">詳細を見る</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <p class="text-zinc-500 mb-6">予定はありません。</p>
    @endif

    <div class="mt-6">
        <a href="{{ route('team.schedules.create', $team) }}" class="inline-block px-4 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition">予定作成</a>
    </div>

  </div>
</x-layouts.app>