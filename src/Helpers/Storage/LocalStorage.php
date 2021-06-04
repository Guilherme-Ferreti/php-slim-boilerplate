<?php

namespace App\Helpers\Storage;

use Slim\Psr7\Stream;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\ResponseInterface as Response;

class LocalStorage
{
    public $disk = '';

    public static function disk(string $disk) : Self
    {
        $self = new Self();

        $self->disk = $disk;

        return $self;
    }

    public function put(UploadedFileInterface $file, string $path = '') : string
    {
        $disk_path = $this->getDiskPath();

        $filename = makeFilename($file);

        $file->moveTo(path($disk_path . $path . $filename));

        return $filename;
    }

    public function delete(string $path) : bool
    {
        $path = path($this->getDiskPath() . $path);

        if (! file_exists($path)) return false;

        return unlink($path);
    }

    public static function url(string $path, string $default = '') : string
    {
        if (! file_exists(path(Self::disk('public')->getDiskPath() . $path))) {
            $filename = basename($path);

            $path = str_replace($filename, $default, $path);
        }

        return settings('storage.local.public_disk_url') . $path;
    }

    public function download(Response $response, string $path) : Response
    {
        $path = path($this->getDiskPath() . $path);

        if (! file_exists($path)) {
            $response->getBody()->write('The requested file could not be found.');

            return $response->withStatus(404);
        }

        $stream = new Stream(fopen($path, 'rb'));

        return $response->withHeader('Content-Type', mimetype($path))
                    ->withHeader('Content-Description', 'File Transfer')
                    ->withHeader('Content-Transfer-Encoding', 'binary')
                    ->withHeader('Content-Disposition', 'attachment; filename="' . basename($path) . '"')
                    ->withHeader('Expires', '0')
                    ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                    ->withHeader('Pragma', 'public')
                    ->withBody($stream);
    }

    private function getDiskPath() : string
    {
        if ($this->disk === 'public') {
            return settings('storage.local.public_disk_path');
        } else {
            return settings('storage.local.private_disk_path');
        }
    }
}
