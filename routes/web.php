<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoDownloaderController;

Route::get('/', [VideoDownloaderController::class, 'index']);
Route::post('/analyze', [VideoDownloaderController::class, 'analyze']);
Route::post('/get-formats', [VideoDownloaderController::class, 'getFormats']);
Route::post('/download', [VideoDownloaderController::class, 'download']);
Route::get('/progress', [VideoDownloaderController::class, 'getProgress']);
Route::get('/active-downloads', [VideoDownloaderController::class, 'getActiveDownloads']);
Route::get('/debug-progress', [VideoDownloaderController::class, 'debugProgress']);
Route::get('/settings', [VideoDownloaderController::class, 'settings']);
Route::post('/open-downloads-folder', [VideoDownloaderController::class, 'openDownloadsFolder']);
