<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoDownloaderController extends Controller
{
    public function index()
    {
        return view('video-downloader');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        // Dummy video info for demonstration
        $videoInfo = [
            'title' => 'فيديو تعليمي - Laravel من الصفر',
            'channel' => 'قناة البرمجة العربية',
            'duration' => '15:30',
            'views' => '125K',
            'thumbnail' => 'https://via.placeholder.com/320x180',
            'qualities' => [
                ['quality' => '1080p', 'size' => '156 MB', 'format' => 'MP4'],
                ['quality' => '720p', 'size' => '89 MB', 'format' => 'MP4'],
                ['quality' => '480p', 'size' => '45 MB', 'format' => 'MP4'],
                ['quality' => 'Audio Only', 'size' => '12 MB', 'format' => 'MP3'],
            ]
        ];

        return response()->json($videoInfo);
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'quality' => 'required|string'
        ]);

        // Dummy download response
        return response()->json([
            'status' => 'success',
            'message' => 'تم بدء التنزيل بنجاح',
            'download_id' => uniqid()
        ]);
    }
}