<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler;

use Spryker\Service\Container\ContainerInterface;
use SprykerShop\Yves\WebProfilerWidget\Plugin\Application\WebProfilerApplicationPlugin;
use SprykerShop\Yves\WebProfilerWidgetExtension\Dependency\Plugin\WebProfilerDataCollectorPluginInterface;
use Symfony\Bridge\Twig\DataCollector\TwigDataCollector;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

class WebProfilerTwigDataCollector implements WebProfilerDataCollectorPluginInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'twig';
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return '@WebProfiler/Collector/twig.html.twig';
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface
     */
    public function getDataCollector(ContainerInterface $container): DataCollectorInterface
    {
        return new TwigDataCollector($container->get(WebProfilerApplicationPlugin::SERVICE_TWIG_PROFILE));
    }
}