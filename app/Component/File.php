<?php

namespace App\Component;

use Verot\Upload\Upload;

/**
 * Class Upload
 * @package App\Component
 */
class File
{

    /**
     * @param $dir
     * @param $file
     * @param $name
     * @return Upload
     * @throws \Exception
     */
    static public function up($dir, $file, $name)
    {

        $handle = new Upload($file);

        $handle->file_new_name_body = $name;
        $handle->file_overwrite = true;
        $handle->allowed = array('image/*', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        if ($handle->uploaded) {
            $handle->process($dir);
            if ($handle->processed) {
                return $handle;
            } else {
                throw new \Exception($handle->error);
            }
        }

        throw new \Exception('Problemas ao enviar arquivo. Tente novamente.');

    }

    /**
     * @param array $data
     * @return array
     */
    static public function clean(array $data): array
    {
        $files = array();
        foreach ($data as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files)) $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }

        return $files;
    }

    static public function getType(string $name)
    {
        $ext = explode('.', $name);
        switch ($ext[1]) {
            case 'pdf':
                return 'pdf';
            case 'txt':
                return 'text';
            case 'webm':
            case 'mkv':
            case 'mp4':
                return 'video';
            case 'xls':
            case 'docx':
            case 'ppt':
            case 'doc':
                return 'office';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'svg':
                return 'image';
        }

    }

}
