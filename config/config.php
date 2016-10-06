<?php

/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['Blioxxx'], 1, array
(
    'bx-galerie' => array
    (
        'tables'      => array('tl_bx_gallery'),
        'icon'        => 'system/modules/bx-galiere/assets/icon.png'
    )
));


/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD'], 2, array
(
    'Blioxxx' => array
    (
        'galiere'    => 'ModuleBXGaliere'
    )
));