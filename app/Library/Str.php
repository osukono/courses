<?php


namespace App\Library;


class Str
{
    public static function normalize($str)
    {
        $str = Str::em_dashes($str);
        $str = Str::en_dashes($str);
//        $str = Str::exaggeration($str);
        $str = Str::grammar($str);

        return $str;
    }

    /**
     * The em dash introduces quoted text at line start.
     * @param $str
     * @return string
     */
    public static function em_dashes($str)
    {
        $hyphen = '-';
        $em_dash = '—';

        return preg_replace("/(^$hyphen )/", "$em_dash ", $str);
    }

    /**
     * A spaced en dash marks a break in a sentence.
     * @param $str
     * @return string
     */
    public static function en_dashes($str)
    {
        $hyphen = '-';
        $en_dash = '–';

        return preg_replace("/( $hyphen )/", " $en_dash ", $str);
    }

    public static function grammar($str)
    {
        return preg_replace('/(.*?)(\[)(.*?)(])(.*?)/', '$1<strong>$3</strong>$5', $str);
    }

//    public static function exaggeration($str)
//    {
//        return preg_replace('/(.*?)({)(.*?)(})(.*?)/', '$1<u>$3</u>$5', $str);
//    }

    public static function toPlainText($str)
    {
        $hyphen = '-';

        $str = preg_replace('/(\[)/', '', $str);
        $str = preg_replace('/(])/', '', $str);
//        $str = preg_replace("/($hyphen{2})/", "$hyphen", $str);

        return $str;
    }
}
