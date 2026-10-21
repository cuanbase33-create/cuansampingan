<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadService
{
    protected ImageManager $manager;

    public function __construct()
    {
        // Instantiate the manager with GD driver as enabled in php.ini
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload, convert to WebP, resize, and store an image.
     */
    public function upload(UploadedFile $file, string $directory, ?int $width = null, ?int $height = null): string
    {
        $filename = Str::uuid() . '.webp';
        $path = $directory . '/' . $filename;

        // Read image
        $image = $this->manager->read($file);

        // Resize if dimensions are specified
        if ($width && $height) {
            $image->cover($width, $height);
        } elseif ($width) {
            $image->scale(width: $width);
        } elseif ($height) {
            $image->scale(height: $height);
        }

        // Encode to WebP (quality 80)
        $encoded = $image->toWebp(80);

        // Save to public disk
        Storage::disk('public')->put($path, $encoded->toString());

        // Return path relative to public directory
        return 'storage/' . $path;
    }
}
