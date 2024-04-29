<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Videos') }}
        </h2>
    </x-slot>

    <div class="flex justify-center flex-wrap">
        @forelse($videos as $video)
            <div class="card w-96 bg-gray-800 shadow-xl m-6">
                <div class="card-body">
                    <h2 class="card-title flex justify-between">
                        <div>
                            @if($video->is_public)
                                <i class="fa-solid fa-globe mr-2"></i>
                            @else
                                <i class="fa-solid fa-lock mr-2 text-red-400"></i>
                            @endif
                            {{ $video->title }}
                        </div>
                        <div>
                            {{$video->created_at->diffForHumans()}}
                        </div>
                    </h2>
                    <p class="line-clamp-1">{{$video->description}}</p>
                    <div class="card-actions justify-between items-center">
                        <div>
                            {{StringHelper::secondsToHuman($video->length)}}
                        </div>
                        <div class="flex">
                            <form action="{{ route("uploads.delete", [$video->id]) }}" method="post">
                                @csrf
                                <button class="btn btn-error" type="submit">Delete</button>
                            </form>
                            <a href="{{ route("video.watch", [$video->id]) }}"
                               class="btn btn-primary ml-2">
                                Watch
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div role="alert" class="alert alert-info max-w-96 m-6">
                <i class="fas fa-info-circle"></i>
                <span>No videos</span>
            </div>
        @endforelse

    </div>
    </main>
</x-app-layout>
