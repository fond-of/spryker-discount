<?php

namespace FondOfSpryker\Zed\Discount;

use FondOfSpryker\Zed\Discount\Dependency\Facade\DiscountCustomMessageToLocaleFacadeBridge;
use Spryker\Zed\Discount\DiscountDependencyProvider as SprykerDiscountDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DiscountDependencyProvider extends SprykerDiscountDependencyProvider
{
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container->set(static::FACADE_LOCALE, static function (Container $container) {
            return new DiscountCustomMessageToLocaleFacadeBridge($container->getLocator()->locale()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDiscountFormDataProviderExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGIN_DISCOUNT_FORM_DATA_PROVIDER_EXPANDER, static function () {
            return $this->getDiscountFormDataProviderExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Plugin\Form\DiscountFormDataProviderExpanderPluginInterface[]
     */
    protected function getDiscountFormDataProviderExpanderPlugins(): array
    {
        return [];
    }
}
