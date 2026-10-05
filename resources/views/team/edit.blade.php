<x-layouts.app :title="__('チーム編集')">
  <div class="p-6">
    <a href="{{ route('team.index', $team) }}" class="text-blue-500 hover:text-blue-700">詳細に戻る</a>
    <form method="POST" action="{{ route('team.update', $team) }}" class="mt-4">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="team_name" class="block text-sm font-bold mb-2">チーム名</label>
        <input type="text" name="team_name" id="team_name" value="{{ $team->team_name }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">

        <label for="event" class="block text-sm font-bold mb-2">種目</label>
        <input type="text" name="event" id="event" value="{{ $team->event }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">

        <label for="latitude" class="block text-sm font-bold mb-2">緯度</label>
        <input type="number" step="any" name="latitude" id="latitude" value="{{ $team->latitude }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">

        <label for="longitude" class="block text-sm font-bold mb-2">経度</label>
        <input type="number" step="any" name="longitude" id="longitude" value="{{ $team->longitude }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">

        <label for="contact" class="block text-sm font-bold mb-2">連絡先</label>
        <input type="text" name="contact" id="contact" value="{{ $team->contact }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        
        @error('team_name')
        <span class="text-red-500 text-xs italic">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新</button>
    </form>
  </div>
</x-layouts.app>
