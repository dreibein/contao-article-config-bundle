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
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace("author", "author;{dreibein_article_config_legend},dreibein_article_config_class,dreibein_article_config_space,dreibein_article_config_background", $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);

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
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getColor(DataContainer $dc)
    {
        $colorArray = [];

        /** @var Database $database */
        $database = Database::getInstance();

        // get layoutId from tl_page
        $layoutId = $dc->activeRecord->layout;

        // page has no own layout (look for parent pages)
        if (!$layoutId) {
            // find the parent page which has a layout
            /** @var Database\Result $page */
            $page = $database->prepare("SELECT pid, layout FROM tl_page WHERE id=?")->limit(1)->execute($dc->activeRecord->pid);
            while ($page->layout == 0) {
                /** @var Database\Result $page */
                $page = $database->prepare("SELECT pid, layout FROM tl_page WHERE id=?")->limit(1)->execute($page->pid);
            }
            $layoutId = $page->layout;
        }
        // get the theme-colors
        if ($layoutId > 0) {
            /** @var Database\Result $theme */
            $theme = $database->prepare("SELECT dreibein_theme_colors FROM tl_theme WHERE id=(SELECT pid FROM tl_layout WHERE id=?)")->limit(1)->execute($layoutId);

            // get the colors
            $colors = unserialize($theme->dreibein_theme_colors);
            foreach ($colors as $color) {
                $colorArray[$color['key']] = $color['value'];
            }
        }
        return $colorArray;
    }
}