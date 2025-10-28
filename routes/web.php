<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoDownloaderController;

Route::get('/', [VideoDownloaderController::class, 'index']);
Route::post('/analyze', [VideoDownloaderController::class, 'analyze']);
Route::post('/download', [VideoDownloaderController::class, 'download']);
