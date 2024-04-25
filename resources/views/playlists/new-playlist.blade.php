<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                New Playlist
            </h2>
            <a href="{{route('playlists.all-playlists')}}" class="btn btn-sm btn-outline btn-info">Back</a>
        </div>
    </x-slot>


    <div class="flex justify-center">

        <form action="{{route('playlists.store')}}" method="POST" class="m-6 w-3/5 flex flex-col">
            @csrf
            <div class="flex flex-col mb-4">
                <label for="name" class="text-white">Title</label>
                <input type="text" name="name" id="name" class="bg-gray-800 textarea textarea-bordered">
            </div>
            <div class="flex flex-col mb-4">
                <label for="description" class="text-white">Description</label>
                <textarea name="description" id="description" class="bg-gray-800 textarea textarea-bordered"></textarea>
            </div>
            <p class="text-white">Select videos</p>
            <div class="flex justify-center flex-wrap bg-gray-800 rounded-lg ">
                @foreach($videos as $video)
                    <div class="m-1">
                        <input class="checkbox" type="checkbox" name="videos[]" value="{{$video->id}}">
                        <label for="videos" class="label-text text-base">{{$video->title}}</label>
                    </div>
                @endforeach

            </div>
            <div class="form-control my-2">
                <label class="label cursor-pointer justify-start">
                    <input type="checkbox" name="is_public" checked="checked" class="checkbox"/>
                    <span class="label-text text-lg pl-4">Public</span>
                </label>
            </div>

            <button type="submit" class="bg-gray-800 btn">Create</button>
        </form>
    </div>


</x-app-layout>
