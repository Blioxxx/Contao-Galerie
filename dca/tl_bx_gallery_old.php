<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Table tl_bx_gallery
 */
$GLOBALS['TL_DCA']['tl_bx_gallery'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'                 => 'Table',
        'enableVersioning'              => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('sorting'),
            'headerFields'            => array('title'),
            'panelLayout'             => 'search,limit',
            'child_record_callback'   => array('tl_bx_gallery', 'generateRowString')
        ),
        'label' => array
        (
            'fields'                    => array('title'),
            'format'                    => '%s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                  => 'act=select',
                'class'                 => 'header_edit_all',
                'attributes'            => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_bx_gallery']['edit'],
                'href'                  => 'act=edit',
                'icon'                  => 'edit.gif'
            ),
            'copy' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_bx_gallery']['copy'],
                'href'                  => 'act=copy',
                'icon'                  => 'copy.gif',
            ),
            'delete' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_bx_gallery']['delete'],
                'href'                  => 'act=delete',
                'icon'                  => 'delete.gif',
                'attributes'            => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_bx_gallery']['show'],
                'href'                  => 'act=show',
                'icon'                  => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                       => '{title_legend},title,picture;'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                       => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                       => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_bx_gallery']['title'],
            'exclude'                   => true,
            'search'                    => true,
            'sorting'                   => true,
            'inputType'                 => 'text',
            'eval'                      => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                       => "varchar(255) NOT NULL default ''"
        ),
        'picture' => array(
            'label'                     => &$GLOBALS['TL_LANG']['tl_bx_gallery']['picture'],
            'inputType'                 => 'fileTree',
            'exclude'                   => true,
            'eval'                      => array('filesOnly'=>true, 'fieldType'=>'radio','mandatory'=>false, 'tl_class'=>'clr'),
            'sql'                       => "binary(16) NULL",
            'load_callback' => array
            (
                array('tl_bx_gallery', 'setSingleSrcFlags')
            ),
            'save_callback' => array
            (
                array('tl_bx_gallery', 'storeFileMetaInformation')
            )
        )
    )
);

class tl_bx_gallery extends \Contao\System
{
    public function __construct()
    {
        $this->import('Database');
        parent::__construct();
    }

    /**
     * Dynamically add flags to the "singleSRC" field
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return mixed
     */
    public function setSingleSrcFlags($varValue, DataContainer $dc)
    {
        if ($dc->activeRecord)
        {
            switch ($dc->activeRecord->type)
            {
                case 'text':
                case 'hyperlink':
                case 'image':
                case 'accordionSingle':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
                    break;

                case 'download':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('allowedDownload');
                    break;
            }
        }

        return $varValue;
    }

    /**
     * Pre-fill the "alt" and "caption" fields with the file meta data
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return mixed
     */
    public function storeFileMetaInformation($varValue, DataContainer $dc)
    {
        if ($dc->activeRecord->singleSRC == $varValue)
        {
            return $varValue;
        }

        $objFile = FilesModel::findByUuid($varValue);

        if ($objFile !== null)
        {
            $arrMeta = deserialize($objFile->meta);

            if (!empty($arrMeta))
            {
                $objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=(SELECT pid FROM " . ($dc->activeRecord->ptable ?: 'tl_article') . " WHERE id=?)")
                    ->execute($dc->activeRecord->pid);

                if ($objPage->numRows)
                {
                    $objModel = new PageModel();
                    $objModel->setRow($objPage->row());
                    $objModel->loadDetails();

                    // Convert the language to a locale (see #5678)
                    $strLanguage = str_replace('-', '_', $objModel->rootLanguage);

                    if (isset($arrMeta[$strLanguage]))
                    {
                        Input::setPost('alt', $arrMeta[$strLanguage]['title']);
                        Input::setPost('caption', $arrMeta[$strLanguage]['caption']);
                    }
                }
            }
        }

        return $varValue;
    }

    /* @begin backendsorting */
    /**
     * Generate a song row and return it as HTML string
     * @param array
     * @return string
     */
    public function generateRowString($arrRow)
    {
        return '<div>' . $arrRow['title'] . '</div>';
    }
    /* @end backendsorting */

}