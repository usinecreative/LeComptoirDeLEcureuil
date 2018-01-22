<?php

namespace JK\CmsBundle\Utils;

class StringUtils
{
    public static function underscore($string)
    {
        return strtolower(
            preg_replace([
                '/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'],
                ['\\1_\\2', '\\1_\\2'],
                str_replace('_', '.', $string)
            )
        );
    }
    
    public static function camelize($string)
    {
        return strtr(
            ucwords(
                strtr(
                    $string,
                    ['_' => ' ', '.' => '_ ', '\\' => '_ ']
                )
            ),
            [' ' => '']
        );
    }
    
    public static function removeLastSlash($string)
    {
        if ('/' === substr($string, strlen($string) - 1)) {
            $string = substr($string, 0, strlen($string) - 1);
        }
    
        return $string;
    }
}
