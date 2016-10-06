<?php

namespace BX\Gallery;

use Blioxxx\Gallery\database;
use \Contao\Module;

class ModuleBXGalerie extends Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_bx_gallery';


    /**
     * Do not show the module if no calendar has been selected
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['bx-galerie'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }
        
        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $database = new database();
        $arrGallery = $database->getAllGalleryItems();

        $this->Template->gallery = $arrGallery;
    }
}