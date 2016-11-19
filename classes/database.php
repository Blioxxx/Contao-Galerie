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
     * @return \Contao\Database\Result
     */
    public function getAllGalleryItems()
    {
        $gallery = $this->Database->prepare('SELECT * FROM tl_bx_gallery')->execute();
        return $gallery;
    }

    /**
     * @param $strObjID
     * @return string
     */
    public function getPictureFromDB($strObjID)
    {
        $query = "SELECT picture FROM tl_bx_gallery WHERE id=?";
        $objPicture = $this->Database->prepare($query)->execute($strObjID);
        $objFile = \FilesModel::findByUuid($objPicture->picture);
        return $objFile->path;
    }
}