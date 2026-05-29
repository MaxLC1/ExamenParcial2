<?php
$dir = __DIR__ . '/app/Modules';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getPathname(), 'Http' . DIRECTORY_SEPARATOR . 'Controllers') !== false) {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'class ') !== false && strpos($content, ' extends Controller') !== false) {
            if (strpos($content, 'use App\Http\Controllers\Controller;') === false) {
                $content = preg_replace('/(namespace App\\\\Modules\\\\[a-zA-Z0-9_]+\\\\Http\\\\Controllers;)/', "$1\n\nuse App\Http\Controllers\Controller;", $content);
                file_put_contents($file->getPathname(), $content);
                echo "Updated " . $file->getFilename() . "\n";
            }
        }
    }
}
