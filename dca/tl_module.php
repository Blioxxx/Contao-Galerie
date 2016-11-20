<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['galiere'] = '{title_legend},name,type,bx-galiere-title;';

$GLOBALS['TL_DCA']['tl_module']['fields']['bx-galiere-title'] = array
(
    'exclude'                 => true,
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bx-galiere-title'],
    'inputType'               => 'checkbox',
    'eval'                    => array('doNotCopy'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);