<?php
// TEST FILE

require './vendor/autoload.php';

use Services\Storage\LocalStorage;
use Services\Storage\S3Storage;

$ls = new LocalStorage();

echo "===== READING `testfile.txt` ======\n";
var_dump($ls->get('testfilea.txt', './'));
echo "\n===== END OF CONTENT `testfile.txt` ======\n";

echo "\n=== move file === To newfolder\n";
var_dump($ls->put('testfile.txt', './newfolder', 'newname.txt'));

echo "===== READING `testfile.txt` ======\n";
echo $ls->get('newname.txt', './newfolder/');
echo "\n===== END OF CONTENT `testfile.txt` ======\n";

echo "\n=== move file === To old state\n";
var_dump($ls->put('./newfolder/newname.txt', '.', 'testfile.txt'));
