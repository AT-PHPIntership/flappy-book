<?php

namespace App\Libraries;

use File;

class Image
{
    /**
     * Update images of Book.
     *
     * @param string $imgFile file image
     * @param string $imgPath path image
     * @param string $oldPath oldpath image
     *
     * @return string
     */
    public static function updateImage($imgFile, $imgPath, $oldPath)
    {
        self::deleteImage($oldPath);
        $name = $imgFile->hashName();
        $imgFile->move($imgPath, $name);
        return $imgPath . $name;
    }
    /**
     * Delete images of Book.
     *
     * @param string $oldPath oldpath image
     *
     * @return string
     */
    public static function deleteImage($oldPath)
    {
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }
    }
}
