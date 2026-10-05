<x-layouts.app :title="__('チーム登録')">
  <div class="p-6">
    <h2 class="font-semibold text-xl mb-4">{{ __('チーム登録') }}</h2>
    <form method="POST" action="{{ route('team.store') }}">
      @csrf
      <div class="mb-4">
        <label for="team_name" class="block text-sm font-bold mb-2">チーム名</label>
        <input type="text" name="team_name" id="team_name" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        
        <label for="event" class="block text-sm font-bold mb-2">種目</label>
        <input type="text" name="event" id="event" class="border rounded w-full py-2 px-3 dark:bg-gray-700">

        <label for="latitude" class="block text-sm font-bold mb-2">緯度</label>
        <input type="number" step="any" name="latitude" id="latitude" class="border rounded w-full py-2 px-3 dark:bg-gray-700">

        <label for="longitude" class="block text-sm font-bold mb-2">経度</label>
        <input type="number" step="any" name="longitude" id="longitude" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        
        <label for="contact" class="block text-sm font-bold mb-2">連絡先</label>
        <input type="text" name="contact" id="contact" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        
        @error('team_name')
        <span class="text-red-500 text-xs italic">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">登録</button>
    </form>
  </div>
</x-layouts.app>
