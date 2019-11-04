<?php

declare(strict_types=1);

/*
 * This file is part of the Dreibein-Article-Config-Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

$table = 'tl_theme';

$GLOBALS['TL_DCA'][$table]['palettes']['default'] = str_replace('templates;', 'templates;{dreibein_theme_config},dreibein_theme_colors;', $GLOBALS['TL_DCA']['tl_theme']['palettes']['default']);

$GLOBALS['TL_DCA'][$table]['fields']['dreibein_theme_colors'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['dreibein_theme_colors'],
    'exclude' => true,
    'inputType' => 'keyValueWizard',
    'sql' => 'blob NULL',
];
