<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Yves\EventDispatcher\Plugin\Application\EventDispatcherApplicationPlugin;
use SprykerShop\Yves\WebProfilerWidgetExtension\Dependency\Plugin\WebProfilerDataCollectorPluginInterface;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\EventDataCollector;

class WebProfilerEventsDataCollectorPlugin implements WebProfilerDataCollectorPluginInterface
{
    protected const NAME = 'events';
    protected const TEMPLATE = '@WebProfiler/Collector/events.html.twig';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return static::TEMPLATE;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface
     */
    public function getDataCollector(ContainerInterface $container): DataCollectorInterface
    {
        return new EventDataCollector($container->get(EventDispatcherApplicationPlugin::SERVICE_DISPATCHER));
    }
}
