<?php
/**
 * Created by PhpStorm.
 * User: thomasvoggenreiter
 * Date: 30.10.17
 * Time: 17:10
 */

$GLOBALS['TL_DCA']['tl_theme']['palettes']['default'] = str_replace("templates;", "templates;{dreibein_theme_config},dreibein_theme_colors;", $GLOBALS['TL_DCA']['tl_theme']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_theme']['fields']['dreibein_theme_colors'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_theme']['dreibein_theme_colors'],
    'exclude'   => true,
    'inputType' => 'keyValueWizard',
    'sql'       => "blob NULL"
];