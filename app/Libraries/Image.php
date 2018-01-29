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
    public static function update($imgFile, $imgPath, $oldPath)
    {
        self::delete($oldPath);
        $name = $imgFile->hashName();
        $imgFile->move($imgPath, $name);
        return $imgPath . $name;
    }
    /**
     * Delete images of Book.
     *
     * @param string $oldPath oldpath image
     *
     * @return void
     */
    public static function delete($oldPath)
    {
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }
    }
}
