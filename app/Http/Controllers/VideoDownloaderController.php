<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoDownloaderController extends Controller
{
    public function index()
    {
        return view('video-downloader');
    }

    public function getFormats(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        
        try {
            $url = escapeshellarg($request->url);
            $command = "yt-dlp -F --print-json {$url}";
            $output = shell_exec($command);
            
            if (!$output) {
                return response()->json(['error' => 'فشل في تحليل الرابط'], 400);
            }
            
            return response()->json(['formats' => $output]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ في التحليل'], 500);
        }
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        try {
            $url = escapeshellarg($request->url);
            $command = "yt-dlp --print-json --no-download {$url}";
            $output = shell_exec($command);
            
            if (!$output) {
                return response()->json(['error' => 'فشل في تحليل الرابط'], 400);
            }

            $data = json_decode($output, true);
            
            $videoInfo = [
                'title' => $data['title'] ?? 'غير متوفر',
                'channel' => $data['uploader'] ?? 'غير متوفر',
                'duration' => $this->formatDuration($data['duration'] ?? 0),
                'views' => $this->formatViews($data['view_count'] ?? 0),
                'thumbnail' => $data['thumbnail'] ?? 'https://via.placeholder.com/320x180',
                'qualities' => $this->extractQualities($data['formats'] ?? [])
            ];

            return response()->json($videoInfo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ في التحليل'], 500);
        }
    }

    private function formatDuration($seconds)
    {
        if (!$seconds) return '0:00';
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    private function formatViews($views)
    {
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }
        return number_format($views);
    }

    private function extractQualities($formats)
    {
        $qualities = [];
        $videoFormats = [];
        
        // Group video formats by quality
        foreach ($formats as $format) {
            if (isset($format['height']) && $format['vcodec'] !== 'none') {
                $height = $format['height'];
                if (!isset($videoFormats[$height]) || 
                    ($format['filesize'] ?? 0) > ($videoFormats[$height]['filesize'] ?? 0)) {
                    $videoFormats[$height] = $format;
                }
            }
        }
        
        // Sort by quality (highest first)
        krsort($videoFormats);
        
        foreach ($videoFormats as $format) {
            $qualities[] = [
                'quality' => $format['height'] . 'p',
                'size' => $this->formatFilesize($format['filesize'] ?? 0),
                'format' => strtoupper($format['ext'] ?? 'MP4'),
                'fps' => $format['fps'] ?? null,
                'vcodec' => $format['vcodec'] ?? null,
                'acodec' => $format['acodec'] ?? null
            ];
        }
        
        // Add audio only option
        $qualities[] = [
            'quality' => 'Audio Only',
            'size' => 'متغير',
            'format' => 'MP3',
            'fps' => null,
            'vcodec' => null,
            'acodec' => 'mp3'
        ];
        
        return $qualities;
    }

    private function formatFilesize($bytes)
    {
        if (!$bytes) return 'غير محدد';
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 1) . ' ' . $units[$pow];
    }

    public function settings()
    {
        return view('settings');
    }

    public function openDownloadsFolder()
    {
        $downloadPath = storage_path('app/downloads');
        
        try {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                exec("start \"\" \"$downloadPath\"");
            } elseif (PHP_OS === 'Darwin') {
                exec("open \"$downloadPath\"");
            } else {
                exec("xdg-open \"$downloadPath\"");
            }
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function getActiveDownloads()
    {
        $downloads = [];
        $progressFiles = glob(storage_path('app/progress_*.txt'));
        
        foreach ($progressFiles as $file) {
            $downloadId = str_replace(['progress_', '.txt'], '', basename($file));
            $content = file_get_contents($file);
            $lines = explode("\n", $content);
            
            $progress = 0;
            $title = 'جاري التنزيل...';
            $status = 'جاري التنزيل';
            $size = '';
            $speed = '';
            
            foreach (array_reverse($lines) as $line) {
                // Match yt-dlp progress format: [download]  45.2% of 123.45MiB at 1.23MiB/s ETA 00:30
                if (preg_match('/\[download\]\s+(\d+\.?\d*)%/', $line, $matches)) {
                    $progress = (float)$matches[1];
                }
                // Match file size
                if (preg_match('/of\s+([\d\.]+\w+)/', $line, $matches)) {
                    $size = $matches[1];
                }
                // Match download speed
                if (preg_match('/at\s+([\d\.]+\w+\/s)/', $line, $matches)) {
                    $speed = $matches[1];
                }
                // Get video title from destination
                if (strpos($line, '[download] Destination:') !== false) {
                    $title = basename(trim(str_replace('[download] Destination:', '', $line)));
                }
                // Check if completed
                if (strpos($line, '[download] 100%') !== false || strpos($line, 'has already been downloaded') !== false) {
                    $progress = 100;
                    $status = 'مكتمل';
                    unlink($file);
                    continue 2;
                }
            }
            
            if ($progress < 100) {
                $downloads[] = [
                    'id' => $downloadId,
                    'title' => $title,
                    'progress' => $progress,
                    'status' => $status,
                    'size' => $size,
                    'speed' => $speed
                ];
            }
        }
        
        return response()->json($downloads);
    }

    public function debugProgress()
    {
        $progressFiles = glob(storage_path('app/progress_*.txt'));
        $debug = [];
        
        foreach ($progressFiles as $file) {
            $content = file_get_contents($file);
            $debug[] = [
                'file' => basename($file),
                'content' => $content,
                'lines' => explode("\n", $content)
            ];
        }
        
        return response()->json($debug);
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'quality' => 'required|string'
        ]);

        try {
            $downloadPath = storage_path('app/downloads');
            if (!file_exists($downloadPath)) {
                mkdir($downloadPath, 0755, true);
            }

            $downloadId = uniqid();
            $progressFile = storage_path("app/progress_{$downloadId}.txt");
            $url = escapeshellarg($request->url);
            $quality = $request->quality;
            
            // Build yt-dlp command with advanced features
            $baseOptions = "--merge-output-format mp4 --no-mtime --write-thumbnail --embed-thumbnail --progress --newline -c";
            $outputTemplate = "\"{$downloadPath}/%(upload_date)s - %(title)s.%(ext)s\"";
            
            if ($quality === 'Audio Only') {
                $command = "yt-dlp -x --audio-format mp3 {$baseOptions} -o {$outputTemplate} {$url} > \"{$progressFile}\" 2>&1";
            } else {
                $height = str_replace('p', '', $quality);
                $command = "yt-dlp -f \"bestvideo[height<={$height}]+bestaudio/best[height<={$height}]\" {$baseOptions} -o {$outputTemplate} {$url} > \"{$progressFile}\" 2>&1";
            }

            // Execute download in background
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                pclose(popen("start /B " . $command, "r"));
            } else {
                exec($command . " > /dev/null 2>&1 &");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'تم بدء التنزيل بنجاح',
                'download_id' => $downloadId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل في بدء التنزيل'
            ], 500);
        }
    }

    public function getProgress(Request $request)
    {
        $downloadId = $request->get('download_id');
        $progressFile = storage_path("app/progress_{$downloadId}.txt");
        
        if (!file_exists($progressFile)) {
            return response()->json(['status' => 'not_found']);
        }
        
        $content = file_get_contents($progressFile);
        $lines = explode("\n", $content);
        
        $progress = 0;
        $title = 'جاري التنزيل...';
        $status = 'جاري التنزيل';
        
        foreach (array_reverse($lines) as $line) {
            if (preg_match('/\[(\d+\.?\d*)%\]/', $line, $matches)) {
                $progress = (float)$matches[1];
                break;
            }
            if (strpos($line, '[download] Destination:') !== false) {
                $title = basename(trim(str_replace('[download] Destination:', '', $line)));
            }
            if (strpos($line, '[download] 100%') !== false) {
                $progress = 100;
                $status = 'مكتمل';
                break;
            }
        }
        
        return response()->json([
            'progress' => $progress,
            'title' => $title,
            'status' => $status,
            'completed' => $progress >= 100
        ]);
    }
}