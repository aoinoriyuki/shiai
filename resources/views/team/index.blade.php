<x-layouts.app :title="__('マイチームページ')">
  <div class="p-6">
    <h2 class="font-semibold text-xl mb-4">{{ __('マイチームページ') }}</h2>
    @if ($team)
    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>チーム名：{{ $team->team_name }}</p>
    </div>
    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>種目：{{ $team->event }}</p>
    </div>
     <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>連絡先：{{ $team->contact }}</p>
    </div>
    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>練習場所：緯度{{ $team->latitude }} ,経度{{ $team->longitude }}</p>
    </div>

    <a href="{{ route('team.edit', $team) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
    @else
    <div class="b-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>{{ __('所属しているチームはありません。') }}</p>
    </div>
    @endif
  </div>
</x-layouts.app>
