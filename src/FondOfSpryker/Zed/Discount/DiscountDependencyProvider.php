<?php

namespace FondOfSpryker\Zed\Discount;

use Spryker\Zed\Discount\DiscountDependencyProvider as SprykerDiscountDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DiscountDependencyProvider extends SprykerDiscountDependencyProvider
{
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER = 'PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER';

    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addDefaultDiscountCreateConfiguratorExpanderPlugin($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDefaultDiscountCreateConfiguratorExpanderPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER, function () {
            return $this->getDefaultDiscountCreateConfiguratorExpanderPlugin();
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Form\DefaultDiscountCreateConfiguratorExpanderPluginInterface[]
     */
    protected function getDefaultDiscountCreateConfiguratorExpanderPlugin(): array
    {
        return [];
    }
}
