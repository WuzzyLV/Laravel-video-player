<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    public function allPlaylists(): View
    {
        $playlists = Playlist::all()->where('is_public', true);
        foreach ($playlists as $playlist) {
            //add all videos to playlists
            $playlist->videos = $playlist->videos()->get();

        }
        return view('playlists.all-playlists', compact('playlists'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $playlist = Playlist::create([
            "name" => $request->name,
            "description" => $request->description,
            'is_public' => $request->input('is_public') == 'on',
            "user_id" => $request->user()->id,
        ]);

        if ($request->has('videos')) {
//            for ($i = 0; $i < count($request->input("videos")); $i++) {
//                $playlist->videos()->attach($request->input("videos")[$i]);
//            }
            foreach ($request->videos as $videoId) {
                $playlist->videos()->attach($videoId);
            }
        }

        return redirect()->route('playlists.all-playlists')->with('success', 'Playlist created!');

    }

    public function watchPlaylist(Request $request, $playlistId)
    {
        $playlist = null;
        try {
            $playlist = Playlist::findOrFail($playlistId);
        } catch (\Exception $e) {
            return view('playlists.watch-playlist', [$playlistId])
                ->withErrors(['error' => 'Playlist not found']);
        }
        $videos = $playlist->videos()->get();

//        check if videos exists
        if ($videos->isEmpty()) {
            return view('playlists.watch-playlist', compact('playlist'))
                ->withErrors(['error' => 'No videos to play']);
        }
        //remove file path
        foreach ($videos as $video) {
            $video->url = route('uploads.get', $video->id);
        }


        return view('playlists.watch-playlist', compact('playlist', 'videos'));
    }

    public function newPlaylist(): View
    {
        $videos = Video::query()->where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('is_public', true);
        })->get();
        return view('playlists.new-playlist', compact('videos'));
    }

    public function deletePlaylist(Request $request, $playlistId): RedirectResponse
    {
        $playlist = $request->user()->playlists()->find($playlistId);
        if ($playlist) {
            $playlist->delete();
        } else {
            return redirect()->back()
                ->withErrors(['error' => 'Playlist not found']);
        }
        return redirect()->back();
    }

    public function userPlaylists(Request $request)
    {
        $playlists = $request->user()->playlists()->get();
        // Pass the filtered videos to the view
        return view('profile.playlists', compact('playlists'));
    }

}
