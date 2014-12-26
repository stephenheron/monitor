<?php

namespace AppBundle\Helper;

class UrlHelper {
    public static function toSingleSlashes($input) {
        return preg_replace('~(^|[^:])//+~', '\\1/', $input);
    }
}