<?php
namespace App\Helpers\Route;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper{
    public static function iterateFiles($path)
    {
        // Automatically Load the routes files using Recursive Iterator
    /** @var RecursiveDirectoryIterator | RecursiveIteratorIterator $iterator */
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path));

    while ($iterator->valid()) {
        if (!$iterator->isDot()&& $iterator->isReadable()
            &&$iterator->isFile()
            &&$iterator->current()->getExtension()=="php") {
            require $iterator->key();
        }
        $iterator->next();
    }
    }
}
