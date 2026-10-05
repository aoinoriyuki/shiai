<x-layouts.app :title="__('チーム検索')">
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
            {{ __('他のチームを検索') }}
        </h2>

        {{-- 検索フォーム --}}
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
            <form method="GET" action="{{ route('team.search') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="w-full sm:w-1/3">
                    <label for="team_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">チーム名</label>
                    <input type="text" name="team_name" id="team_name" value="{{ request('team_name') }}" placeholder="チーム名で検索" class="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg px-4 py-2 bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full sm:w-1/3">
                    <label for="event" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">種目</label>
                    <input type="text" name="event" id="event" value="{{ request('event') }}" placeholder="種目で検索" class="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg px-4 py-2 bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition">
                        検索
                    </button>
                </div>
                <div class="w-full sm:w-auto">
                    <a href="{{ route('team.search') }}" class="block text-center px-4 py-2 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-800 dark:text-zinc-200 font-bold rounded-lg transition">
                        クリア
                    </a>
                </div>
            </form>
        </div>

        {{-- 検索結果 --}}
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">
                検索結果 ({{ $teams->total() }}件)
            </h3>

            @if($teams->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($teams as $team)
                        <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                            <h4 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                                {{ $team->team_name }}
                            </h4>
                            <div class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 mb-4">
                                <p><span class="font-medium text-zinc-700 dark:text-zinc-300">種目：</span>{{ $team->event }}</p>
                                <p><span class="font-medium text-zinc-700 dark:text-zinc-300">連絡先：</span>{{ Str::limit($team->contact, 30) }}</p>
                            </div>
                            <div class="pt-4 border-t border-zinc-100 dark:border-zinc-700">
                                <a href="{{ route('team.show', $team) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm flex items-center gap-1">
                                    チームの詳細を見る <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ページネーション --}}
                <div class="mt-6">
                    {{ $teams->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl p-8 text-center text-zinc-500 dark:text-zinc-400">
                    条件に一致するチームは見つかりませんでした。
                </div>
            @endif
        </div>

    </div>
</x-layouts.app>
