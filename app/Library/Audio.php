<?php


namespace App\Library;


class Audio
{
    public static function length($audio) {
//        dd($audio);
        $output = static::duration($audio);

        $seconds = substr($output, 0, strpos($output, '.'));
        $milliseconds = substr($output, strpos($output, '.') + 1);
        $milliseconds = str_pad($milliseconds, 3, '0');
        $milliseconds = substr($milliseconds, 0, 3);

        return ($seconds * 1000) + $milliseconds;
    }

    private static function duration($audio) {
        return exec("sox " . $audio . " -n stat 2>&1 | sed -n 's#^Length (seconds):[^0-9]*\([0-9.]*\).*$#\\1#p'");
    }

    private static function aacDuration($audio) {
        $wav = $audio . ".wav";
        exec("ffmpeg -i " . $audio . " " . $wav);
        return exec("sox " . $wav . " -n stat 2>&1 | sed -n 's#^Length (seconds):[^0-9]*\([0-9.]*\).*$#\\1#p'");
    }
}
