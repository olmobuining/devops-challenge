<?php

use Aws\S3\S3Client;
use PHPUnit\Framework\TestCase;
use Services\Storage\S3Storage;

final class S3StorageTest extends TestCase
{
    protected $client_mock;

    protected function setUp(): void
    {
        $this->client_mock = $this->getMockBuilder(S3Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['getObject', 'putObject'])
            ->getMock();
    }

    public function testExistingFile(): void
    {
        $bucket = 'bucket';
        $filename = 'testfile.txt';

        $this->client_mock
            ->expects($this->once())
            ->method('getObject')
            ->with([
                'Bucket' => $bucket,
                'Key'    => $filename
            ])
            ->will($this->returnValue(['Body' => "yes file content"]));

        $storage = new S3Storage($this->client_mock);
        $file_content = $storage->get($filename, $bucket);

        $this->assertSame("yes file content", $file_content, "Make sure file content is what we expect (of our testfile)");
    }

    public function testNonExistingFile(): void
    {
        $bucket = 'bucket';
        $filename = 'testfileb.txt';

        $this->client_mock
            ->expects($this->once())
            ->method('getObject')
            ->with([
                'Bucket' => $bucket,
                'Key'    => $filename
            ])
            ->will($this->throwException(new Exception()));

        $this->expectException(Exception::class);

        $storage = new S3Storage($this->client_mock);
        $storage->get($filename, $bucket); // Exception here.
    }

    public function testPutExistingFile(): void
    {
        $this->client_mock
            ->expects($this->once())
            ->method('putObject')
            ->will($this->returnValue(['ObjectURL' => "amazon.link/newfolder/newname.txt"]));

        $storage = new S3Storage($this->client_mock);

        $new_location = $storage->put('./testfile.txt', 'newfolder', 'newname.txt');

        $this->assertSame('amazon.link/newfolder/newname.txt', $new_location);
    }
}
