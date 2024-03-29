<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\WebProfilerExtension\Dependency\Plugin\WebProfilerDataCollectorPluginInterface;
use SprykerShop\Yves\WebProfilerWidget\Plugin\Application\WebProfilerApplicationPlugin;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\TimeDataCollector;

class WebProfilerTimeDataCollectorPlugin implements WebProfilerDataCollectorPluginInterface
{
    /**
     * @var string
     */
    protected const NAME = 'time';

    /**
     * @var string
     */
    protected const TEMPLATE = '@WebProfiler/Collector/time.html.twig';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return static::TEMPLATE;
    }

    /**
     * {@inheritDoc}
     * - Adds a TimeDataCollector which collects information about timing.
     *
     * @api
     *
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface
     */
    public function getDataCollector(ContainerInterface $container): DataCollectorInterface
    {
        return new TimeDataCollector(null, $container->get(WebProfilerApplicationPlugin::SERVICE_STOPWATCH));
    }
}
