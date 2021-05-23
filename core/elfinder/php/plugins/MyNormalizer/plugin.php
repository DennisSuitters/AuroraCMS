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
            $str = substr($str,0,strripos($str, '.')+1).$ext;
        }
        $str=str_replace(' ','-',$str);
        return $str;
    }
}
