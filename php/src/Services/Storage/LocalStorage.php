<?php

namespace Services\Storage;

use Exception;

class LocalStorage implements StorageInterface
{
    public function get(string $filename, string $path): string
    {
        $full_path = $path . $filename;
        if (is_file($full_path)) {
            return file_get_contents($full_path);
        }

        throw new Exception("Failed to get file: '" . $full_path . "'");
    }

    public function put(string $pathToFile, string $newLocation, string $newName)
    {
        try {
            if (!file_exists($newLocation)) {
                mkdir($newLocation, 0777, true);
            }

            if (rename($pathToFile, $newLocation . DIRECTORY_SEPARATOR . $newName)) {
                return $newLocation . DIRECTORY_SEPARATOR . $newName;
            }
        } catch (Exception $e) {
            // log the exception?
            throw new Exception("Failed to move local file to new location");
        }
    }
}
