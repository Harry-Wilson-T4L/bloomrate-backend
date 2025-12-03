<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\PostAttachment;
class UploadAssetsToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 's3:upload-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload all files from public/assets to S3 bucket';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // $localPath = public_path('chat_attachments'); // Only "assets" folder

        // $files = File::allFiles($localPath); // Get all files recursively
        
        // foreach ($files as $file) {
        //     // Get the path inside the "assets" folder
        //     $relativePathInAssets = $file->getRelativePathname(); // e.g. css/style.css
        
        //     // Upload to S3: assets/css/style.css
        //     $s3Path = 'chat_attachments/' . $relativePathInAssets;
        
        //     Storage::disk('s3')->put($s3Path, file_get_contents($file), 'private');
        
        //     echo "Uploaded: $s3Path\n";
        // }
        // $this->info("All attachments processed successfully.");

        // $attachments = PostAttachment::where('media_type', 'video')->get();

        // foreach ($attachments as $attachment) {
        //     // Get the S3 path stored in 'media' column
        //     $s3Path = $attachment->media; 
        
        //     if (Storage::disk('s3')->exists($s3Path)) {
        //         echo "Video exists in S3: {$s3Path}" . PHP_EOL;
        //     } else {
        //         echo "Video NOT found in S3: {$s3Path}" . PHP_EOL;
        //     }
        // }

        $missingAttachments = [];

        $attachments = PostAttachment::where('media_type', 'video')->get();
        
        foreach ($attachments as $attachment) {
            if (!$attachment->media) {
                // media is null
                $missingAttachments[] = $attachment;
                continue;
            }
        
            if (!Storage::disk('s3')->exists($attachment->media)) {
                $missingAttachments[] = $attachment;
            }
        }
        
        // Now you have only missing videos
        foreach ($missingAttachments as $missing) {
            echo " Missing Video ID: {$missing->id}, Path: {$missing->media}" . PHP_EOL;
        }

        // $attachments = PostAttachment::all(); 

        // foreach ($attachments as $attachment) {
        //     if ($attachment->media_type === 'video') {
        //         $localVideoPath = storage_path('app/temp_' . basename($attachment->media));
        
        //         $videoContent = Storage::disk('s3')->get($attachment->media);
        //         file_put_contents($localVideoPath, $videoContent);
        
        //         $hlsDir = storage_path('app/hls_' . time() . rand(1000, 9999));
        //         File::makeDirectory($hlsDir);
        
        //         $hlsFileName = 'index.m3u8';
        //         $cmd = "ffmpeg -i \"$localVideoPath\" -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls \"$hlsDir/$hlsFileName\"";
        //         exec($cmd);
        
        //         $hlsFiles = File::files($hlsDir);
        //         $s3HlsPath = 'media/hls/' . time() . rand(1000, 9999) . '/';
        
        //         foreach ($hlsFiles as $file) {
        //             $stream = fopen($file->getRealPath(), 'r');
        //             Storage::disk('s3')->writeStream($s3HlsPath . $file->getFilename(), $stream, ['visibility' => 'private']);
        //             fclose($stream);
        //         }
        
        //         $attachment->media_new = $s3HlsPath . $hlsFileName;
        //         $attachment->save();
        
        //         // Cleanup
        //         File::deleteDirectory($hlsDir); // Cleanupp
        //         unlink($localVideoPath);
        
        //         $this->info("Video converted to HLS and uploaded");
        //     } elseif ($attachment->media_type === 'image') {
                
        //         $attachment->media_new = $attachment->media;
        //         $attachment->save();
        
        //         $this->info("Image path copied to media_new: {$attachment->id}");
        //     }
        // }
        
        // $this->info("All attachments processed successfully.");
    }
}
