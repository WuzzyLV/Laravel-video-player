<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All videos') }}
        </h2>
    </x-slot>


    <div class="text-white flex gap-6 flex-wrap justify-center m-10">
        @forelse($uploadedFiles as $uploadedFile)
            <div class="card w-96 bg-gray-800 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title flex justify-between">
                        <div>
                            {{$uploadedFile->title}}
                        </div>
                        <div>
                            {{$uploadedFile->created_at->diffForHumans()}}
                        </div>
                    </h2>
                    <p class="line-clamp-1">{{$uploadedFile->description}}</p>
                    <div class="card-actions justify-between items-center">
                        <div>
                            {{StringHelper::secondsToHuman($uploadedFile->length)}}
                        </div>
                        <a
                            href="{{ route("video.watch", [$uploadedFile->id]) }}"
                            class="btn btn-primary"
                        >
                            Watch
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td>No uploads found</td>
            </tr>
        @endforelse

    </div>

</x-app-layout>
