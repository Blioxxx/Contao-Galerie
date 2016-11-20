<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['galiere'] = '{title_legend},name,type,bxGaliereTitle;';

$GLOBALS['TL_DCA']['tl_module']['fields']['bxGaliereTitle'] = array
(
    'exclude'                 => true,
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bx-galiere-title'],
    'inputType'               => 'checkbox',
    'eval'                    => array('doNotCopy'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);