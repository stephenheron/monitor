<?php

namespace AppBundle\Entity;

abstract class AbstractResource
{

    public function getName()
    {
        $path = parse_url($this->getUrl(), PHP_URL_PATH);
        $fileName = basename($path);
        return $fileName;
    }

    public function getSourceLinesOfCode()
    {
        if($this->getContent()) {
            return substr_count( $this->getContent(), "\n" );
        } else {
            return 0;
        }
    }

}
