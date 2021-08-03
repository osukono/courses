<?php


namespace App\Library;


use function Aws\map;

class StrUtils
{
    public static function splitChunks(string $str) {
//        return preg_split('/\[(.*?)\] ?/', $str, -1,  PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        return array_map('trim', preg_split('/\|/', $str));
    }

    public static function splitExtraChunks(string $str) : array {
        return array_map('trim', preg_split('/,/', $str));
    }

    public static function deleteBetween($from, $to, $source) {
        $fromPos = strpos($source, $from);
        if ($fromPos === false)
            return $source;

        $toPos = strpos($source, $to, $fromPos);
        if ($toPos === false)
            return $source;

        return substr($source, 0, $fromPos) . substr($source, $toPos + strlen($to));
    }

    /**
     * @param string $str
     * @param bool $grammar
     * @return string
     */
    public static function normalize($str, $grammar = true)
    {
        $str = StrUtils::em_dashes($str);
        $str = StrUtils::en_dashes($str);
        $str = StrUtils::apostrophe($str);
        if ($grammar)
            $str = StrUtils::grammar($str);

        return $str;
    }

    /**
     * @param $str
     * @return array|string|string[]|null
     */
    public static function apostrophe($str) {
        $typewriter = "'";
        $typesetter = "’";

        return preg_replace("/($typesetter)/", "$typewriter", $str);
    }

    /**
     * The em dash introduces quoted text at line start.
     * @param string $str
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
     * @param string $str
     * @return string
     */
    public static function en_dashes($str)
    {
        $hyphen = '-';
        $en_dash = '–';

        return preg_replace("/( $hyphen )/", " $en_dash ", $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function grammar($str)
    {
        return preg_replace('/(.*?)(\[)(.*?)(])(.*?)/', '$1<strong>$3</strong>$5', $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function toPlainText($str)
    {
        $str = preg_replace('/(\[)/', '', $str);
        $str = preg_replace('/(])/', '', $str);

        return $str;
    }
}
