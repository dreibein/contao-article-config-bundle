<?php

declare(strict_types=1);

/*
 * This file is part of the Dreibein-Article-Config-Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Dreibein\ArticleConfigBundle\DataContainer;

use Contao\DataContainer;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\ThemeModel;
use Dreibein\ArticleConfigBundle\Model\DreibeinThemeModel;

class Article
{
    /**
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getColors(DataContainer $dc): array
    {
        $colorArray = [];

        // get layoutId from tl_page
        $layoutId = $dc->activeRecord->layout;

        // page has no own layout (look for parent pages)
        if (!$layoutId) {
            $page = PageModel::findById((int) $dc->activeRecord->pid);
            while ($page && (int) $page->layout === 0) {
                $page = PageModel::findById((int) $page->pid);
            }
            $layoutId = $page->layout;
        }

        $layout = LayoutModel::findById($layoutId);
        if ($layout !== null) {
            /** @var DreibeinThemeModel $theme */
            $theme = ThemeModel::findById($layout->pid);
            if ($theme) {
                $colors = StringUtil::deserialize($theme->dreibein_theme_colors);
                foreach ($colors as $color) {
                    $colorArray[$color['key']] = $color['value'];
                }
            }
        }

        return $colorArray;
    }
}
