<?php

namespace App\Http\Controllers;

use App\Models\VideoView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class FileController extends Controller
{
    public static $maxFileSize = 1024 * 100; // 100MB

    // stores the upload
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. Refuses anything bigger than 2048 kilobyes (=2MB)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file_upload' => 'required|mimes:mp4|max:' . self::$maxFileSize,
        ]);

        // Store the file in storage\app\videos folder
        $file = $request->file('file_upload');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('videos', '');


        $id3 = (new \getID3)->analyze($file->getRealPath());

        $duration = intval($id3['playtime_seconds']);

        // Store file information in the database
        $request->user()->videos()->save(new Video([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'filename' => $fileName,
            'file_path' => $filePath,
            'length' => $duration,
            'is_public' => $request->input('is_public') == 'on',
        ]));

        // Redirect back to the index page with a success message
        return redirect()->route('home')
            ->with('success', "File `{$fileName}` uploaded successfully.");
    }

    // shows the create form
    public function create()
    {
        return view('uploads.create');
    }

    public function get($fileId)
    {
        $file = Video::find($fileId);

        if (!$file) {
            return response()->json([
                'message' => 'File not found.',
                'id' => $fileId
            ], 404);
        }


        return response()->file(
            storage_path(("app/" . $file->file_path)),
            [
                'Content-Type' => "video/mp4",
                'Content-Disposition' => 'inline; filename="' . $file->original_name . '"'
            ],
        );
    }

    public function delete(Request $request, $fileId)
    {
        $file = $request->user()->videos()->find($fileId);

        if (!$file) {
            return redirect()->back()
                ->withErrors(['error' => 'File not found']);
        }

        $file->delete();
        Storage::delete($file->file_path);

        return redirect()->back();
//            ->with('success', "File `{$file->original_name}` deleted successfully.");
    }

    public function userVideos(Request $request)
    {
        $videos = $request->user()->videos()->get();
        // Pass the filtered videos to the view
        return view('profile.videos', compact('videos'));
    }

    public function watch(Request $request, $fileId)
    {
        $video = Video::find($fileId);

        if (!$video) {
            return response()->json([
                'message' => 'File not found.',
                'id' => $fileId
            ], 404);
        }

        $view = $request->user()->views()
            ->where('video_id', $video->id)->first();

        if (!$view) {
            $request->user()->views()->save(new VideoView([
                'video_id' => $video->id,
            ]));
        } else {
            $view->increment('views');
        }

        return view('video.watch', compact('video'));
    }

    // shows the uploads index
    public function index()
    {
        $uploadedFiles = Video::all()->where('is_public', true);
        return view('home', compact('uploadedFiles'));
    }
}
