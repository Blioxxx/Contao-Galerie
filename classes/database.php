<?php

namespace Blioxxx\Gallery;

use \Contao\System;

class database extends System
{
    public function __construct()
    {
        $this->import('Database');
        parent::__construct();
    }

    /**
     * Gives back all gallery items
     * @return array
     */
    public function getAllGalleryItems()
    {
        $gallery = $this->Database->prepare('SELECT * FROM tl_bx_gallery')->execute()->fetchAllAssoc();
        return $gallery;
    }

}