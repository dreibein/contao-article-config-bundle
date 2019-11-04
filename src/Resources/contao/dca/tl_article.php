<?php

declare(strict_types=1);

/*
 * This file is part of the Dreibein-Article-Config-Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Resources\contao\dca;

use Dreibein\ArticleConfigBundle\DataContainer\Article;

$table = 'tl_article';

$GLOBALS['TL_DCA'][$table]['palettes']['default'] = str_replace('author', 'author;{dreibein_article_config_legend},dreibein_article_config_class,dreibein_article_config_space,dreibein_article_config_background', $GLOBALS['TL_DCA'][$table]['palettes']['default']);

$GLOBALS['TL_DCA'][$table]['fields']['dreibein_article_config_class'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['dreibein_article_config_class'],
    'exclude' => 'true',
    'inputType' => 'select',
    'options' => ['no-inside'],
    'reference' => &$GLOBALS['TL_LANG'][$table]['dreibein_article_config_class'],
    'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true],
    'sql' => "varchar(10) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['dreibein_article_config_space'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['dreibein_article_config_space'],
    'exclude' => 'true',
    'inputType' => 'select',
    'options' => ['space-p', 'space-pt', 'space-pb'],
    'reference' => &$GLOBALS['TL_LANG'][$table]['dreibein_article_config_space'],
    'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true],
    'sql' => "varchar(10) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['dreibein_article_config_background'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['dreibein_article_config_background'],
    'exclude' => 'true',
    'inputType' => 'select',
    'options_callback' => [Article::class, 'getColors'],
    'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true],
    'sql' => "varchar(60) NOT NULL default ''",
];
