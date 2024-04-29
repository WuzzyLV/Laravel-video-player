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
        <div class="flex justify-center items-center flex-col bg-gray-700 bg-opacity-50">
            <div class="flex-row flex px-24" id="video-container">
                <video controls id="video" class="w-9/12 flex justify-center">
                    <source id="video-src" type="video/mp4">
                </video>
                <div class="bg-gray-800 w-full flex flex-col relative">
                    <div class="flex px-6  font-bold justify-between border-b" id="header-container">
                        <h2 class="text-lg" id="name">Name</h2>
                        <h2 class="text-lg" id="length">Length</h2>
                    </div>
                    <div class="overflow-auto pb-4 max-h-0" id="video-list-container">
                        @foreach($videos as $video)
                            <div
                                class="flex justify-between items-center px-6 p-2 border-b cursor-pointer playlist-video"
                                id="{{$video->id}}">
                                <h3 class="text-lg">{{$video->title}}</h3>
                                <p class="text-lg ml">
                                    {{StringHelper::secondsToHuman($video->length)}}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="justify-center flex absolute bottom-0 w-full h-12 py-2 border-t bg-gray-800 z-10"
                         id="controls">
                        <i class="fa-solid fa-backward-step text-lg mx-4 cursor-pointer" id="prev-btn"></i>
                        <i class="fa-solid fa-play text-lg mx-4 cursor-pointer" id="pause-btn"></i>
                        <i class="fa-solid fa-forward-step text-lg px-4 cursor-pointer" id="next-btn"></i>
                        <i class="fa-solid fa-shuffle text-lg px-4 border-l cursor-pointer" id="shuffle-btn"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-6">
            <div class="flex justify-between text-xl font-bold">
                <h3 id="video-title">Title</h3>
            </div>
            <p class="ml-2 mt-2" id="video-desc">{{$video->description}}</p>
        </div>

        <script type="module">
            let video = $('#video')[0];
            let videoSrc = $('#video-src')[0];
            let videoTitle = $('#video-title')[0];
            let videoDesc = $('#video-desc')[0];

            let currentIndex = 0;

            let videos = @json($videos);
            shufflePlaylist(videos)

            console.log(videos);

            function playVideo(id) {
                videoSrc.src = videos[id].url;
                video.load();
                $('#video').on('loadeddata', function () {
                    video.play();
                });
                videoTitle.innerText = videos[id].title;
                videoDesc.innerText = videos[id].description;
                $('#' + videos[currentIndex].id).css('background-color', 'transparent');
                $('#' + videos[id].id).css('background-color', 'rgba(255, 255, 255, 0.1)');

                currentIndex = id;
            }

            $(document).ready(function () {
                playVideo(0);
            });

            function nextVideo() {
                if (currentIndex < videos.length - 1) {
                    playVideo(currentIndex + 1)
                }
            }

            function prevVideo() {
                if (currentIndex > 0) {
                    playVideo(currentIndex - 1)
                }
            }

            $('#video').on('ended', nextVideo);

            $('#prev-btn').click(prevVideo);

            $('#pause-btn').click(function () {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            })

            $('#next-btn').click(nextVideo);

            $(document).on('click', '.playlist-video', function () {
                console.log($(this).attr('id'));
                let id = $(this).attr('id');
                let realID;
                for (let i = 0; i < videos.length; i++) {
                    if (videos[i].id == id) {
                        realID = i;
                        break;
                    }
                }
                playVideo(realID);
            });

            function redrawPlaylist() {
                let videoList = $('#video-list-container');
                let temp = $('.playlist-video').clone();
                videoList.empty();
                for (let i = 0; i < videos.length; i++) {
                    for (let j = 0; j < temp.length; j++) {
                        let id = $(temp[j]).attr('id');
                        if (id == videos[i].id) {
                            videoList.append(temp[j]);
                            $('#' + id).css('background-color', 'transparent');
                            break;
                        }
                    }
                }
            }

            $('#shuffle-btn').click(function () {
                shufflePlaylist(videos);
                redrawPlaylist()
                playVideo(0);
            })

            // 0 unsorted, 1 ascending, 2 descending
            let nameSorted = 0;

            $('#name').click(function () {
                if (nameSorted == 0) {
                    videos.sort((a, b) => a.title.localeCompare(b.title));
                    nameSorted = 1;
                } else if (nameSorted == 1) {
                    videos.sort((a, b) => b.title.localeCompare(a.title));
                    nameSorted = -1;
                }
                redrawPlaylist();
                playVideo(0);
            })

            function shufflePlaylist(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    let j = Math.floor(Math.random() * (i + 1));
                    let temp = array[i];
                    array[i] = array[j];
                    array[j] = temp;
                }
                return array;
            }


        </script>

        @vite('resources/js/playlistListCalculation.js')
    @endif

</x-app-layout>
