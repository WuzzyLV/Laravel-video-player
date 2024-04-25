<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
        >
            {{ $video->title}}
        </h2>
    </x-slot>
    <div class="flex justify-center bg-gray-700 bg-opacity-50">
        <video controls id="video" class="w-8/12 flex justify-center">
            <source id="video-src" src="{{route("uploads.get", ['fileId' => $video->id])}}" type="video/mp4">
        </video>
    </div>
    <div class="m-6">
        <div class="flex justify-between text-xl font-bold">
            <h3 class="">Description</h3>
            <h3>
                <i class="fas fa-eye font-normal"></i>
                {{$video->uniqueViewCount()}}
            </h3>
        </div>
        <p class="ml-2 mt-2">{{$video->description}}</p>
    </div>
</x-app-layout>
