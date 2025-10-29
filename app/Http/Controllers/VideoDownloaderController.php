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
        // Clean up old progress files (older than 1 hour)
        $this->cleanupOldProgressFiles();
        
        $downloads = [];
        $downloadInfoFiles = glob(storage_path('app/download_info_*.json'));
        
        foreach ($downloadInfoFiles as $infoFile) {
            $downloadId = str_replace(['download_info_', '.json'], '', basename($infoFile));
            $progressFile = storage_path("app/progress_{$downloadId}.txt");
            
            if (!file_exists($progressFile)) continue;
            
            $downloadInfo = json_decode(file_get_contents($infoFile), true);
            $progressContent = file_get_contents($progressFile);
            $lines = explode("\n", $progressContent);
            
            $progress = 0;
            $title = $downloadInfo['title'] ?? 'جاري التنزيل...';
            $status = 'جاري التنزيل';
            $size = '';
            $speed = '';
            $currentFile = '';
            
            // Parse progress from yt-dlp output
            foreach ($lines as $line) {
                $line = trim($line);
                
                // Get destination file but keep original title
                if (strpos($line, '[download] Destination:') !== false) {
                    $currentFile = trim(str_replace('[download] Destination:', '', $line));
                    // Only update title if we don't have the original one
                    if ($title === 'جاري التنزيل...') {
                        $title = $downloadInfo['title'] ?? basename($currentFile);
                    }
                }
                
                // Check for completion
                if (strpos($line, '100%') !== false || strpos($line, 'has already been downloaded') !== false) {
                    $progress = 100;
                    $status = 'مكتمل';
                    unlink($progressFile);
                    unlink($infoFile);
                    continue 2;
                }
                
                // Parse progress percentage - multiple patterns
                if (preg_match('/\[(\d+(?:\.\d+)?)%\]/', $line, $matches)) {
                    $progress = (float)$matches[1];
                }
                
                // Parse size and speed info
                if (preg_match('/(\d+(?:\.\d+)?[KMGT]?B)\s+at\s+(\d+(?:\.\d+)?[KMGT]?B\/s)/', $line, $matches)) {
                    $size = $matches[1];
                    $speed = $matches[2];
                }
                
                // Alternative progress pattern
                if (preg_match('/\s+(\d+(?:\.\d+)?)%\s+of\s+([\d\.]+[KMGT]?B)\s+at\s+([\d\.]+[KMGT]?B\/s)/', $line, $matches)) {
                    $progress = (float)$matches[1];
                    $size = $matches[2];
                    $speed = $matches[3];
                }
            }
            
            // If no progress found in log, try to calculate from file sizes
            if ($progress == 0) {
                $downloadPath = storage_path('app/downloads');
                $baseFileName = pathinfo($title, PATHINFO_FILENAME);
                
                // Look for final merged file first
                $finalFile = $downloadPath . '/' . $baseFileName . '.mp4';
                if (file_exists($finalFile)) {
                    $progress = 100;
                    $status = 'مكتمل';
                    unlink($progressFile);
                    unlink($infoFile);
                    continue;
                }
                
                // Look for downloading files (.part, .f136.mp4, .f251.webm, etc.)
                $downloadingFiles = glob($downloadPath . '/' . $baseFileName . '*');
                $totalCurrentSize = 0;
                
                foreach ($downloadingFiles as $file) {
                    if (is_file($file) && !strpos($file, '.jpg') && !strpos($file, '.webp')) {
                        $totalCurrentSize += filesize($file);
                    }
                }
                
                $expectedSize = $downloadInfo['expected_size'] ?? 0;
                if ($expectedSize > 0 && $totalCurrentSize > 0) {
                    $progress = min(99, ($totalCurrentSize / $expectedSize) * 100);
                    if (!$size) $size = $this->formatFilesize($totalCurrentSize) . ' / ' . $this->formatFilesize($expectedSize);
                } else if ($totalCurrentSize > 0) {
                    // If no expected size, show current size only
                    if (!$size) $size = $this->formatFilesize($totalCurrentSize);
                    $progress = 10; // Show some progress if files exist
                }
            }
            
            if ($progress < 100) {
                $downloads[] = [
                    'id' => $downloadId,
                    'title' => $title,
                    'progress' => round($progress, 1),
                    'status' => $status,
                    'size' => $size,
                    'speed' => $speed
                ];
            }
        }
        
        return response()->json($downloads);
    }

    public function testProgress($id)
    {
        $progressFile = storage_path("app/progress_{$id}.txt");
        
        if (!file_exists($progressFile)) {
            return response()->json(['error' => 'Progress file not found']);
        }
        
        $content = file_get_contents($progressFile);
        $lines = explode("\n", $content);
        
        return response()->json([
            'raw_content' => $content,
            'lines' => $lines,
            'last_10_lines' => array_slice($lines, -10)
        ]);
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

    public function getRecentDownloads()
    {
        $downloadPath = storage_path('app/downloads');
        
        // Search for MP4 files recursively
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($downloadPath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        $files = [];
        foreach ($iterator as $file) {
            if ($file->getExtension() === 'mp4') {
                $files[] = $file->getPathname();
            }
        }
        
        $recentDownloads = [];
        
        // Sort by modification time (newest first)
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        // Get last 5 downloads
        $files = array_slice($files, 0, 5);
        
        foreach ($files as $file) {
            $baseName = pathinfo($file, PATHINFO_FILENAME);
            $fileDir = dirname($file);
            
            // Check for different thumbnail formats in the same directory
            $thumbnailUrl = null;
            $thumbnailExtensions = ['webp', 'jpg', 'jpeg', 'png'];
            
            foreach ($thumbnailExtensions as $ext) {
                $thumbnailPath = $fileDir . '/' . $baseName . '.' . $ext;
                if (file_exists($thumbnailPath)) {
                    // Create relative path from storage/app/downloads
                    $relativePath = str_replace($downloadPath . '/', '', $thumbnailPath);
                    $relativePath = str_replace('\\', '/', $relativePath); // Convert backslashes to forward slashes
                    $thumbnailUrl = '/storage/downloads/' . $relativePath;
                    break;
                }
            }
            
            $recentDownloads[] = [
                'title' => basename($file),
                'size' => $this->formatFilesize(filesize($file)),
                'date' => date('Y-m-d H:i', filemtime($file)),
                'thumbnail' => $thumbnailUrl
            ];
        }
        
        return response()->json($recentDownloads);
    }

    public function pauseDownload(Request $request)
    {
        $downloadId = $request->download_id;
        
        try {
            // Kill the yt-dlp process
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                exec("taskkill /f /im yt-dlp.exe");
            } else {
                exec("pkill -f yt-dlp");
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'تم إيقاف التنزيل مؤقتاً'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل في إيقاف التنزيل'
            ], 500);
        }
    }

    private function cleanupOldProgressFiles()
    {
        $progressFiles = glob(storage_path('app/progress_*.txt'));
        $infoFiles = glob(storage_path('app/download_info_*.json'));
        
        foreach ($progressFiles as $file) {
            // Delete files older than 1 hour
            if (filemtime($file) < time() - 3600) {
                unlink($file);
            }
        }
        
        foreach ($infoFiles as $file) {
            // Delete files older than 1 hour
            if (filemtime($file) < time() - 3600) {
                unlink($file);
            }
        }
    }

    public function cancelDownload(Request $request)
    {
        $downloadId = $request->download_id;
        
        try {
            // Kill the yt-dlp process
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                exec("taskkill /f /im yt-dlp.exe");
            } else {
                exec("pkill -f yt-dlp");
            }
            
            // Clean up files
            $progressFile = storage_path("app/progress_{$downloadId}.txt");
            $infoFile = storage_path("app/download_info_{$downloadId}.json");
            
            if (file_exists($progressFile)) unlink($progressFile);
            if (file_exists($infoFile)) unlink($infoFile);
            
            // Remove all download-related files
            $downloadPath = storage_path('app/downloads');
            
            // Get download info to find the actual file
            if (file_exists($infoFile)) {
                $downloadInfo = json_decode(file_get_contents($infoFile), true);
                $title = $downloadInfo['title'] ?? '';
                
                if ($title) {
                    $baseFileName = pathinfo($title, PATHINFO_FILENAME);
                    
                    // Delete all files with this base name (video, audio, thumbnails, etc.)
                    $patterns = [
                        $downloadPath . '/' . $baseFileName . '.*',
                        $downloadPath . '/*' . $baseFileName . '*'
                    ];
                    
                    foreach ($patterns as $pattern) {
                        $filesToDelete = glob($pattern);
                        foreach ($filesToDelete as $file) {
                            if (is_file($file)) {
                                unlink($file);
                            }
                        }
                    }
                }
            }
            
            // Remove any remaining .part, .tmp, .ytdl files
            $tempPatterns = [
                $downloadPath . '/*.part',
                $downloadPath . '/*.tmp', 
                $downloadPath . '/*.ytdl',
                $downloadPath . '/*.f*.*'
            ];
            
            foreach ($tempPatterns as $pattern) {
                $tempFiles = glob($pattern);
                foreach ($tempFiles as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'تم إلغاء التنزيل'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل في إلغاء التنزيل'
            ], 500);
        }
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'quality' => 'required|string'
        ]);

        try {
            // Get video info first to store expected file size
            $url = escapeshellarg($request->url);
            $infoCommand = "yt-dlp --print-json --no-download {$url}";
            $infoOutput = shell_exec($infoCommand);
            $videoInfo = json_decode($infoOutput, true);
            
            $downloadPath = storage_path('app/downloads');
            if (!file_exists($downloadPath)) {
                mkdir($downloadPath, 0755, true);
            }

            $downloadId = uniqid();
            $progressFile = storage_path("app/progress_{$downloadId}.txt");
            $quality = $request->quality;
            
            // Store download info for progress tracking
            $downloadInfo = [
                'id' => $downloadId,
                'title' => $videoInfo['title'] ?? 'Unknown',
                'expected_size' => 0,
                'output_path' => '',
                'start_time' => time()
            ];
            
            // Find expected file size based on quality
            if (isset($videoInfo['formats'])) {
                foreach ($videoInfo['formats'] as $format) {
                    if ($quality === 'Audio Only') {
                        if ($format['acodec'] !== 'none' && $format['vcodec'] === 'none') {
                            $downloadInfo['expected_size'] = $format['filesize'] ?? 0;
                            break;
                        }
                    } else {
                        $height = str_replace('p', '', $quality);
                        if (isset($format['height']) && $format['height'] <= $height) {
                            $downloadInfo['expected_size'] = $format['filesize'] ?? 0;
                        }
                    }
                }
            }
            
            file_put_contents(storage_path("app/download_info_{$downloadId}.json"), json_encode($downloadInfo));
            
            // Build yt-dlp command
            $baseOptions = "--merge-output-format mp4 --no-mtime --write-thumbnail --convert-thumbnails webp --progress --newline";
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
        $size = '';
        $speed = '';
        
        // Process lines from newest to oldest
        foreach (array_reverse($lines) as $line) {
            $line = trim($line);
            
            // Get destination file but keep original title from download info
            if (strpos($line, '[download] Destination:') !== false && $title === 'جاري التنزيل...') {
                $infoFile = storage_path("app/download_info_{$downloadId}.json");
                if (file_exists($infoFile)) {
                    $downloadInfo = json_decode(file_get_contents($infoFile), true);
                    $title = $downloadInfo['title'] ?? basename(trim(str_replace('[download] Destination:', '', $line)));
                } else {
                    $title = basename(trim(str_replace('[download] Destination:', '', $line)));
                }
            }
            
            // Check completion
            if (strpos($line, '[download] 100%') !== false || strpos($line, '100%') !== false) {
                $progress = 100;
                $status = 'مكتمل';
                break;
            }
            
            // Parse progress - multiple patterns
            if (preg_match('/\[(\d+(?:\.\d+)?)%\]/', $line, $matches)) {
                $progress = (float)$matches[1];
            }
            
            // Alternative progress patterns
            if (preg_match('/(\d+(?:\.\d+)?)%\s+of/', $line, $matches)) {
                $progress = (float)$matches[1];
            }
            
            // Parse size and speed
            if (preg_match('/(\d+(?:\.\d+)?[KMGT]?B)\s+at\s+(\d+(?:\.\d+)?[KMGT]?B\/s)/', $line, $matches)) {
                $size = $matches[1];
                $speed = $matches[2];
            }
            
            // Break if we found progress
            if ($progress > 0) break;
        }
        
        return response()->json([
            'progress' => $progress,
            'title' => $title,
            'status' => $status,
            'size' => $size,
            'speed' => $speed,
            'completed' => $progress >= 100
        ]);
    }
}