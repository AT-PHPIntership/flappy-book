<?php

namespace App\Libraries;

use File;

class Image
{
    /**
     * Update images of Book.
     *
     * @param string $imgFile file image
     *
     * @return string
     */
    public static function update($imgFile)
    {
        $name = $imgFile->hashName();
        $path = config('image.book.path');
        $imgFile->move($path, $name);
        return $name;
    }

    /**
     * Delete images of Book.
     *
     * @param string $imgName Name of image
     *
     * @return void
     */
    public static function delete($imgName)
    {
        $oldPath = config('image.book.path') . $imgName;
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }
    }
}
