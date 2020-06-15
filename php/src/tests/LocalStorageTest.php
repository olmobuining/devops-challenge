<?php

use PHPUnit\Framework\TestCase;
use Services\Storage\LocalStorage;

final class LocalStorageTest extends TestCase
{
    public function testExistingFile(): void
    {
        $local_storage = new LocalStorage();
        $file_content = $local_storage->get('testfile.txt', './');

        $this->assertSame("yes file content", $file_content, "Make sure file content is what we expect (of our testfile)");
    }

    public function testExceptionNonExistingFile(): void
    {
        $this->expectException(Exception::class);

        $local_storage = new LocalStorage();
        $local_storage->get('doesnotexist.txt', 'unknownlocation');
    }

    public function testPutExistingFile(): void
    {
        $local_storage = new LocalStorage();
        $new_location = $local_storage->put('./testfile.txt', 'newfolder', 'newname.txt');
        $this->assertSame('newfolder/newname.txt', $new_location);
        $this->assertTrue(is_file('newfolder/newname.txt'));

        // Reverting back to old state
        $old_location = $local_storage->put('./newfolder/newname.txt', '.', 'testfile.txt');
        $this->assertSame('./testfile.txt', $old_location);
        $this->assertTrue(is_file('./testfile.txt'));
    }
}
