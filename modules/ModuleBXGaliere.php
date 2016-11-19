<?php

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

        if (TL_MODE == "FE")
        {
            //$GLOBALS['TL_CSS'][] = 'system/modules/cw_portfolio/assets/css/framework.css|screen';
            //$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/cw_portfolio/assets/js/isotope.js';

            $GLOBALS['TL_CSS'][] = 'composer/vendor/twitter/bootstrap/dist/css/bootstrap.min.css|screen';
        }
        
        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $database = new database();
        $objGallery = $database->getAllGalleryItems();

        $arrGallery = array();
        
        while($objGallery->next())
        {
            $arrGallery[] = array(
                'picture'   => $database->getPictureFromDB($objGallery->id),
            );
        }

        $this->Template->gallery = $arrGallery;
    }
}