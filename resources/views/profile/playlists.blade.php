<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Playlists') }}
        </h2>
    </x-slot>

    <div class="flex justify-center">
        @forelse($playlists as $playlist)
            <x-playlist :playlist="$playlist" :personal="true"/>

        @empty
            <div role="alert" class="alert alert-info max-w-96 m-6">
                <i class="fas fa-info-circle"></i>
                <span>No playlists</span>
            </div>
        @endforelse

    </div>
    </main>
</x-app-layout>
