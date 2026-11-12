<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait ImageUploadTrait
{
    public function uploadImage($file, $path)
    {
        $imageName = uniqid() . '.webp';

        $gd = new Driver();
        $manager = new ImageManager($gd);

        $image = $manager->read($file)->toWebp(90);
        Storage::disk('public')->put($path . $imageName, (string)$image);
        return $imageName;
    }
}
