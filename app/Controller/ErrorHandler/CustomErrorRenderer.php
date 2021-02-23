<?php


namespace App\Controller\ErrorHandler;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class CustomErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $a = $this->file_get_contents(__DIR__ . '/../../../app/View/error/404.html');
        return $a;
    }

    function file_get_contents($filename)
    {
        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return $contents;
    }

}