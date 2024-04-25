<x-app-layout>


    @if ($errors->any())
        <div class="flex justify-center">
            <div role="alert" class="alert alert-error m-6 w-1/2">
                @foreach ($errors->all() as $error)
                    <i class="fa-regular fa-circle-xmark text-lg"></i>
                    <span class="text-center">{{ $error }}</span>
                @endforeach
            </div>
        </div>
    @else

        <x-slot name="header">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{$playlist->name}}
                </h2>
                {{--            <a href="{{route('playlists.new-playlist')}}" class="btn btn-sm btn-outline btn-info">New</a>--}}
            </div>
        </x-slot>
        <div class="flex justify-around items-center bg-gray-700 bg-opacity-50">
            <button class="btn btn-circle btn-outline" id="prev-btn">
                <i class="fa-solid fa-backward-step text-lg"></i>
            </button>
            <video controls id="video" class="w-8/12 flex justify-center">
                <source id="video-src" type="video/mp4">
            </video>
            <button class="btn btn-circle btn-outline" id="next-btn">
                <i class="fa-solid fa-forward-step text-lg"></i>
            </button>
        </div>

        <div class="m-6">
            <h3 class="text-xl font-bold" id="video-title"></h3>
            <p class="ml-2 mt-2" id="video-desc"></p>
        </div>


        <script>
            let video = $('#video')[0];
            let videoSrc = $('#video-src')[0];
            let videoTitle = $('#video-title')[0];
            let videoDesc = $('#video-desc')[0];

            let currentIndex = 0;

            let videos = @json($videos);

            console.log(videos);
            $(document).ready(function () {
                videoSrc.src = videos[0].url;
                video.load();
                videoTitle.innerText = videos[0].title;
                videoDesc.innerText = videos[0].description;
            });

            function nextVideo() {
                if (currentIndex < videos.length - 1) {
                    currentIndex++;
                    videoSrc.src = videos[currentIndex].url;
                    video.load();
                    videoTitle.innerText = videos[currentIndex].title;
                    videoDesc.innerText = videos[currentIndex].description;
                }
            }

            function prevVideo() {
                if (currentIndex > 0) {
                    currentIndex--;
                    videoSrc.src = videos[currentIndex].url;
                    video.load();
                    videoTitle.innerText = videos[currentIndex].title;
                    videoDesc.innerText = videos[currentIndex].description;
                }
            }

            $('#video').on('ended', nextVideo);

            $('#prev-btn').click(prevVideo);

            $('#next-btn').click(nextVideo)
        </script>

    @endif

</x-app-layout>
