<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoDownloaderController;

Route::get('/', [VideoDownloaderController::class, 'index']);
Route::post('/analyze', [VideoDownloaderController::class, 'analyze']);
Route::post('/get-formats', [VideoDownloaderController::class, 'getFormats']);
Route::post('/download', [VideoDownloaderController::class, 'download']);
Route::get('/progress', [VideoDownloaderController::class, 'getProgress']);
Route::get('/active-downloads', [VideoDownloaderController::class, 'getActiveDownloads']);
Route::get('/recent-downloads', [VideoDownloaderController::class, 'getRecentDownloads']);
Route::post('/pause-download', [VideoDownloaderController::class, 'pauseDownload']);
Route::post('/cancel-download', [VideoDownloaderController::class, 'cancelDownload']);

// Create storage link for thumbnails
if (!file_exists(public_path('storage'))) {
    app('files')->link(storage_path('app'), public_path('storage'));
}
Route::get('/debug-progress', [VideoDownloaderController::class, 'debugProgress']);
Route::get('/test-progress/{id}', [VideoDownloaderController::class, 'testProgress']);
Route::get('/settings', [VideoDownloaderController::class, 'settings']);
Route::post('/open-downloads-folder', [VideoDownloaderController::class, 'openDownloadsFolder']);
