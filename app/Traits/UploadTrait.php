<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        try {
            $name = !is_null($filename) ? $filename : Str::random(25);
    
            $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
            $img = Image::make($uploadedFile)->orientate();
            $img->fit(100, 100, function ($constraint) {
                $constraint->upsize();
            });
            $img->save(public_path(str_replace('posts', 'post_thumbnails', $folder)).$name.'.'.$uploadedFile->getClientOriginalExtension(), 100);

            return $file;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
