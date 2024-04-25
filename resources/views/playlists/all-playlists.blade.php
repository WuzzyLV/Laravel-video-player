<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                All Playlists
            </h2>
            <a href="{{route('playlists.new-playlist')}}" class="btn btn-sm btn-outline btn-info">New</a>
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center">

        @forelse($playlists as $playlist)
            <x-playlist :playlist="$playlist" :personal="false"/>
        @empty
            <tr>
                <td>No playlists found</td>
            </tr>
        @endforelse
    </div>

</x-app-layout>
