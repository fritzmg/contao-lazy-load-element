<?php

namespace InspiredMinds\ContaoLazyLoadElement\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use InspiredMinds\ContaoLazyLoadElement\ContaoLazyLoadElementBundle;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoLazyLoadElementBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
