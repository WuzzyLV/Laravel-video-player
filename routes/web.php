<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FileController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/videos/', [FileController::class, 'userVideos'])->name('profile.videos');
    Route::get('/profile/playlists/', [PlaylistController::class, 'userPlaylists'])->name('profile.playlists');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
//    Route::get('/uploads', [FileController::class, 'index'])->name('uploads.index');
    Route::get('/uploads/create', [FileController::class, 'create'])->name('uploads.create');
    Route::post('/uploads/store', [FileController::class, 'store'])->name('uploads.store');

    Route::get('/uploads/get/{fileId}', [FileController::class, 'get'])->name('uploads.get');
    Route::post('/uploads/delete/{fileId}', [FileController::class, 'delete'])->name('uploads.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/video/{fileId}', [FileController::class, 'watch'])->name('video.watch');

    Route::get('/playlists/new', [PlaylistController::class, 'newPlaylist'])->name('playlists.new-playlist');
    Route::get('/playlists/{playlistId}', [PlaylistController::class, 'watchPlaylist'])->name('playlists.watch-playlist');
    Route::post('/playlists/{playlistId}', [PlaylistController::class, 'deletePlaylist'])->name('playlists.delete-playlist');
    Route::get('/playlists', [PlaylistController::class, 'allPlaylists'])->name('playlists.all-playlists');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
});


require __DIR__ . '/auth.php';
