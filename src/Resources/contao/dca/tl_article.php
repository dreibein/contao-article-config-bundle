<?php
/**
 * Created by PhpStorm.
 * User: thomasvoggenreiter
 * Date: 30.10.17
 * Time: 13:37
 */

namespace Resources\contao\dca;


use Contao\Backend;
use Contao\Database;

$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace("author;", "author;{dreibein_article_config_legend},dreibein_article_config_class,dreibein_article_config_space,dreibein_article_config_background;", $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_article']['fields']['dreibein_article_config_class'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['dreibein_article_config_class'],
    'exclude'   => 'true',
    'inputType' => 'select',
    'options'   => ['no-inside'],
    'reference' => &$GLOBALS['TL_LANG']['tl_article']['dreibein_article_config_class'],
    'eval'      => ['tl_class'=>'w50', 'includeBlankOption'=>true],
    'sql'       => "varchar(10) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_article']['fields']['dreibein_article_config_space'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['dreibein_article_config_space'],
    'exclude'   => 'true',
    'inputType' => 'select',
    'options'   => ['space-p', 'space-pt', 'space-pb'],
    'reference' => &$GLOBALS['TL_LANG']['tl_article']['dreibein_article_config_space'],
    'eval'      => ['tl_class'=>'w50', 'includeBlankOption'=>true],
    'sql'       => "varchar(10) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_article']['fields']['dreibein_article_config_background'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_article']['dreibein_article_config_background'],
    'exclude'          => 'true',
    'inputType'        => 'select',
    'options_callback' => [tl_dreibein_article::class, 'getColor'],
    'eval'             => ['tl_class'=>'w50', 'includeBlankOption'=>true],
    'sql'              => "varchar(60) NOT NULL default ''"
];

/**
 * Class tl_dreibein_article
 * @package Resources\contao\dca
 */
class tl_dreibein_article extends Backend
{
    /**
     * @return array
     */
    public function getColor()
    {
        $colorArray = [];

        $database = Database::getInstance();
        $colors   = $database->prepare("SELECT color FROM tl_dreibein_article_background")->execute();

        while ($colors->next()) {
            $colorArray[$colors->color] = $colors->color;
        }

        return $colorArray;
    }
}