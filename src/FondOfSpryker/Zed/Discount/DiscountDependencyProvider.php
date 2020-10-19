<?php

namespace FondOfSpryker\Zed\Discount;

use Spryker\Zed\Discount\DiscountDependencyProvider as SprykerDiscountDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DiscountDependencyProvider extends SprykerDiscountDependencyProvider
{
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER = 'PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER';
    public const PLUGIN_DISCOUNT_ENTITY_HYDRATOR = 'PLUGIN_DISCOUNT_ENTITY_HYDRATOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
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
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addDiscountEntityHydratorPlugins($container);

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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDiscountEntityHydratorPlugins(Container $container): Container
    {
        $container->set(static::PLUGIN_DISCOUNT_ENTITY_HYDRATOR, function () {
            return $this->getDiscountEntityHydratorPlugins();
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Persistence\DiscountEntityHydratorPluginInterface[]
     */
    protected function getDiscountEntityHydratorPlugins(): array
    {
        return [];
    }
}
