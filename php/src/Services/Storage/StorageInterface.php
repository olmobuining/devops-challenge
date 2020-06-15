<?php

namespace Services\Storage;

interface StorageInterface
{
    public function get(string $filename, string $path): string;
    public function put(string $pathToFile, string $newLocation, string $newName);
}
