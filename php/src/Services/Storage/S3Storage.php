<?php

namespace Services\Storage;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Exception;

class S3Storage implements StorageInterface
{
    private $client;

    public function __construct(S3Client $client)
    {
        $this->client = $client;
    }

    public function get(string $filename, string $bucket): string
    {
        try {
            $result = $this->client->getObject([
                'Bucket' => $bucket,
                'Key'    => $filename
            ]);

            return $result['Body'];
        } catch (S3Exception $e) {
            // log it?
            throw new Exception("File not found");
        }
    }

    public function put(string $path_to_file, string $new_location, string $new_name)
    {
        try {
            $result = $this->client->putObject([
                'Bucket'        => $new_location,
                'Key'           => $new_name,
                'SourceFile'    => $path_to_file,
            ]);

            return $result['ObjectURL'];
        } catch (S3Exception $e) {
            // log it?
            throw new Exception("Failed to upload file to s3");
        }
    }
}
