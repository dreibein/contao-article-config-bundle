<?php

declare(strict_types=1);

/*
 * This file is part of the Dreibein-Article-Config-Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Dreibein\ArticleConfigBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Dreibein\ArticleConfigBundle\DreibeinArticleConfigBundle;

/**
 * Class Plugin.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * @param ParserInterface $parser
     *
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(DreibeinArticleConfigBundle::class)->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
