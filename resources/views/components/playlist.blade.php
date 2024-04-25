@props(['playlist', 'personal'])

@if ($playlist)
    <div class="card w-96 bg-gray-800 shadow-xl m-6">

        <div class="card-body p-6">
            <h3 class="card-title justify-between">
                <div>
                    @if($playlist->is_public)
                        <i class="fa-solid fa-globe mr-2"></i>
                    @else
                        <i class="fa-solid fa-lock mr-2 text-red-400"></i>
                    @endif
                    {{ $playlist->name }}
                </div>
                <div>
                    {{$playlist->created_at->diffForHumans()}}
                </div>
            </h3>
            <p class="line-clamp-1 pl-2">
                <i class="fa-solid fa-arrow-right-long mr-2"></i>
                {{ $playlist->description}}
            </p>
            <div class="">
                <p class="line-clamp-1 mt-2">
                    @if($playlist->videos->count() == 1)
                        {{ $playlist->videos->count() }} video:
                    @else
                        {{ $playlist->videos->count() }} videos:
                    @endif
                </p>
                <ul class="overflow-auto h-12 border rounded-lg px-2">
                    @forelse($playlist->videos as $video)
                        <li class="flex justify-between">
                            <a href="{{route("video.watch", [$video->id])}}">
                                "{{ $video->title }}"
                            </a>
                            {{StringHelper::secondsToHuman($video->length)}}
                        </li>
                    @empty
                        <tr>
                            <td>No videos found</td>
                        </tr>
                    @endforelse
                </ul>
            </div>
            <div class="card-actions justify-end items-center">
                <div class="flex">
                    @if($personal)
                        <form action="{{route('playlists.delete-playlist', [$playlist->id])}}" method="post">
                            @csrf
                            <button class="btn btn-error" type="submit">Delete</button>
                        </form>
                    @endif
                    @if($playlist->videos->count() > 0)
                        <a href="{{route('playlists.watch-playlist', [$playlist->id])}}" class="btn btn-primary ml-2">
                            Watch
                        </a>
                    @else
                        <a href="{{route('playlists.watch-playlist', [$playlist->id])}}" class="btn btn-disabled ml-2">
                            Watch
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endif
