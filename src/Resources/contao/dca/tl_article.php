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
        $layoutId = 0;

        /** @var Database\Result $page */
        $page = $database->prepare("SELECT pid, layout FROM tl_page WHERE id=?")->execute($dc->activeRecord->pid);
        if ($page->numRows === 1) {
            $layoutId = $page->layout;

            if ($layoutId === 0 && $page->pid > 0) {
                $layoutId = $this->getPageLayout($page);
            }
        }
        if ($layoutId > 0) {
            /** @var Database\Result $theme */
            $theme = $database->prepare("SELECT dreibein_theme_colors FROM tl_theme WHERE id=(SELECT pid FROM tl_layout WHERE id=?)")->execute($layoutId);
            if ($theme->numRows === 1) {
                $colors = unserialize($theme->dreibein_theme_colors);
                foreach ($colors as $color) {
                    $colorArray[$color['key']] = $color['value'];
                }
            }
        }
        return $colorArray;
    }

    /**
     * @param Database\Result $page
     *
     * @return int
     */
    private function getPageLayout(Database\Result $page)
    {
        $layoutId = 0;

        /** @var Database $database */
        $database = Database::getInstance();

        /** @var Database\Result $page */
        $page = $database->prepare("SELECT pid, layout FROM tl_page WHERE id=?")->execute($page->pid);
        if ($page->numRows === 1) {
            /** @var int $layoutId */
            $layoutId = $page->layout;

            if ($layoutId === 0 && $page->pid > 0) {
                $this->getPageLayout($page);
            }
        }
        return $layoutId;
    }
}