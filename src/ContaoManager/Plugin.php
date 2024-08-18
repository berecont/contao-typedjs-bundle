<?php

declare(strict_types=1);

/*
 * This file is part of Typedjs.
 * 
 * (c) Bernhard Renner <info@berecont.at>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/berecont/contao-typedjs-bundle
 */

namespace Berecont\ContaoTypedjsBundle\ContaoManager;

use Berecont\ContaoTypedjsBundle\BerecontContaoTypedjsBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Class Plugin
 */
class Plugin implements BundlePluginInterface
{
    /**
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(BerecontContaoTypedjsBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class
                ]),
        ];
    }
}