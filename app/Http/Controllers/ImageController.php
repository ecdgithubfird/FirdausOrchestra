<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Your existing code to handle image upload goes here...

        // Assuming the upload was successful
        // Now call the method to move images to Azure Storage
        $this->moveImagesToAzure();

        return 'Image uploaded successfully and moved to Azure Storage!';
    }

    private function moveImagesToAzure()
    {
        $images = Storage::files('photos/1'); // Assuming your images are stored in 'storage/app/photos/1' directory

        foreach ($images as $image) {
            $filename = pathinfo($image, PATHINFO_FILENAME);
            $extension = pathinfo($image, PATHINFO_EXTENSION);

            // Move the image to Azure Storage
            Storage::disk('azure')->put('photos/1/' . $filename . '.' . $extension, Storage::get($image));

            // Delete the image from local storage if needed
            // Storage::delete($image);
        }
    }
}
