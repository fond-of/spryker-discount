<?php

namespace FondOfSpryker\Zed\Discount;

use FondOfSpryker\Zed\Discount\Dependency\Facade\DiscountToLocaleFacadeBridge;
use FondOfSpryker\Zed\DiscountCustomMessages\Communication\Plugin\DiscountCustomMessageCalculatorPlugin;
use Spryker\Zed\Discount\DiscountDependencyProvider as SprykerDiscountDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DiscountDependencyProvider extends SprykerDiscountDependencyProvider
{
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER = 'PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER';
    public const PLUGIN_CUSTOM_MESSAGE_CONNECTOR_PLUGIN = 'PLUGIN_CUSTOM_MESSAGE_CONNECTOR_PLUGIN';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addDefaultDiscountCreateConfiguratorExpanderPlugin($container);
        $container = $this->addCustomMessageConnectorPlugin($container);
        $container = $this->addLocaleFacade($container);

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
        $container = $this->addCustomMessageConnectorPlugin($container);

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
    protected function addCustomMessageConnectorPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_CUSTOM_MESSAGE_CONNECTOR_PLUGIN, function () {
            return new DiscountCustomMessageCalculatorPlugin();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return new DiscountToLocaleFacadeBridge($container->getLocator()->locale()->facade());
        });

        return $container;
    }
}
