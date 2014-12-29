<?php

namespace AppBundle\Helper;

class UrlHelper {
    public static function toSingleSlashes($input) {
        return preg_replace('~(^|[^:])//+~', '\\1/', $input);
    }

    public static function getPathFromUrl($url) {
        $parts = parse_url($url);

        $path = $parts['path'];

        if(isset($parts['query'])){
            $path .= $parts['query'];
        }

        if(isset($parts['fragment'])){
            $path .= $parts['fragment'];
        }

        return $path;
    }
}