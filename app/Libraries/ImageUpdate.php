<?php

namespace App\Libraries;

use File;

class ImageUpdate
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
    public static function imageUpdate($imgFile, $imgPath, $oldPath)
    {
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }
            $name = $imgFile->hashName();
            $folder = $imgPath;
            $imgFile->move($folder, $name);
            $newPath = $folder . $name;
            return $newPath;
    }
}
