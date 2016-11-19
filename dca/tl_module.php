<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['galiere'] = '{title_legend},name,type,bx-galiere-title;';

$GLOBALS['TL_DCA']['tl_module']['fields']['bx-galiere-title'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bx-galiere-title'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array(
        'Anzeigen',
        'Nicht anzeigen'
    ),
    'default'                 => 'Nicht anzeigen',
    'eval'                    => array('mandatory'=>false, 'multiple'=>false, 'tl_class'=>'w50'),
    'sql'                     => "varchar(128) NOT NULL default ''",
);