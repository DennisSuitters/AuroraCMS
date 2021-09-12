<?php
class elFinderPluginMyNormalizer extends elFinderPluginNormalizer
{
    protected function normalize($str, $opts) {
        $str = parent::normalize($str, $opts);
        if (!empty($opts['ext_lowercase'])) {
            $ext = substr($str,strripos($str, '.') + 1);
            if (function_exists('mb_strtolower')) {
                $ext = mb_strtolower($ext, 'UTF-8');
            } else {
                $ext = strtolower($ext);
            }
            $str = substr($str, 0, strripos($str, '.') + 1) . $ext;
        }
        $str = str_replace(' ', '-', $str);
        $str = str_replace('_', '-', $str);
        $str = str_replace("'", '-', $str);
        $str = str_replace('"', '-', $str);
        $str = str_replace('%', '-', $str);
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = rawurlencode($str);
        return $str;
    }
}
