<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\WebProfilerWidget;

use Spryker\Shared\Twig\Loader\FilesystemLoader;
use Spryker\Shared\Twig\Loader\FilesystemLoaderInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Form\Extension\DataCollector\FormDataCollector;
use Symfony\Component\Form\Extension\DataCollector\FormDataCollectorInterface;
use Symfony\Component\Form\Extension\DataCollector\FormDataExtractor;
use Symfony\Component\Form\Extension\DataCollector\FormDataExtractorInterface;
use Symfony\Component\Form\Extension\DataCollector\Proxy\ResolvedTypeFactoryDataCollectorProxy;
use Symfony\Component\Form\Extension\DataCollector\Type\DataCollectorTypeExtension;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;
use Symfony\Component\HttpKernel\Profiler\FileProfilerStorage;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\HttpKernel\Profiler\ProfilerStorageInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Twig\Profiler\Profile;

/**
 * @method \SprykerShop\Yves\WebProfilerWidget\WebProfilerWidgetConfig getConfig()
 */
class WebProfilerWidgetFactory extends AbstractFactory
{
    /**
     * @deprecated Use {@link \SprykerShop\Yves\WebProfilerWidget\Plugin\Application\WebProfilerApplicationPlugin} instead.
     *
     * @return array<\Silex\ServiceProviderInterface>
     */
    public function getWebProfiler()
    {
        return $this->getProvidedDependency(WebProfilerWidgetDependencyProvider::PLUGINS_WEB_PROFILER);
    }

    public function createTwigFilesystemLoader(): FilesystemLoaderInterface
    {
        return new FilesystemLoader($this->getConfig()->getWebProfilerTemplatePaths(), 'WebProfiler');
    }

    /**
     * @return array<\Spryker\Shared\WebProfilerExtension\Dependency\Plugin\WebProfilerDataCollectorPluginInterface>
     */
    public function getDataCollectorPlugins(): array
    {
        return $this->getProvidedDependency(WebProfilerWidgetDependencyProvider::PLUGINS_DATA_COLLECTORS);
    }

    public function createStopwatch(): Stopwatch
    {
        return new Stopwatch();
    }

    public function createProfiler(): Profiler
    {
        return new Profiler($this->createProfilerStorage());
    }

    public function createProfilerStorage(): ProfilerStorageInterface
    {
        return new FileProfilerStorage('file:' . $this->getConfig()->getProfilerCacheDirectory());
    }

    public function createProfile(): Profile
    {
        return new Profile();
    }

    public function createResolvedTypeFactoryDataCollectorProxy(): ResolvedFormTypeFactoryInterface
    {
        return new ResolvedTypeFactoryDataCollectorProxy(
            $this->createResolvedFormTypeFactory(),
            $this->createFormDataCollector(),
        );
    }

    public function createResolvedFormTypeFactory(): ResolvedFormTypeFactoryInterface
    {
        return new ResolvedFormTypeFactory();
    }

    public function createFormDataCollector(): FormDataCollectorInterface
    {
        return new FormDataCollector($this->createFormDataExtractor());
    }

    public function createFormDataExtractor(): FormDataExtractorInterface
    {
        return new FormDataExtractor();
    }

    public function createDataCollectorTypeExtension(): FormTypeExtensionInterface
    {
        return new DataCollectorTypeExtension($this->createFormDataCollector());
    }
}
