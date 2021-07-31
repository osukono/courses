<?php


namespace App\Library;


class Audio
{
    public static function duration($audio) {
        $output = exec("sox " . $audio . " -n stat 2>&1 | sed -n 's#^Length (seconds):[^0-9]*\([0-9.]*\).*$#\\1#p'");

        $seconds = substr($output, 0, strpos($output, '.'));
        $milliseconds = substr($output, strpos($output, '.') + 1);
        $milliseconds = str_pad($milliseconds, 3, '0');
        $milliseconds = (int) substr($milliseconds, 0, 3);

        return ($seconds * 1000) + $milliseconds;
    }
}
