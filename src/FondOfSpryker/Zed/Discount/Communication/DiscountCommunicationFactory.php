<?php

namespace FondOfSpryker\Zed\Discount\Communication;

use FondOfSpryker\Zed\Discount\Communication\Form\DataProvider\DiscountFormDataProvider;
use FondOfSpryker\Zed\Discount\Dependency\Facade\DiscountToLocaleFacadeInterface;
use FondOfSpryker\Zed\Discount\DiscountDependencyProvider;
use Spryker\Zed\Discount\Communication\DiscountCommunicationFactory as SprykerDiscountCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\Discount\Business\DiscountFacadeInterface getFacade()
 */
class DiscountCommunicationFactory extends SprykerDiscountCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Discount\Communication\Form\DataProvider\DiscountFormDataProvider
     */
    public function createDiscountFormDataProvider()
    {
        $discountFormDataProvider = new DiscountFormDataProvider(
            $this->getFacade(),
            $this->getDefaultDiscountCreateConfiguratorExpanderPlugin()
        );
        $discountFormDataProvider->applyFormDataExpanderPlugins($this->getDiscountFormDataProviderExpanderPlugins());

        return $discountFormDataProvider;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Form\DefaultDiscountCreateConfiguratorExpanderPluginInterface[]
     */
    public function getDefaultDiscountCreateConfiguratorExpanderPlugin(): array
    {
        return $this->getProvidedDependency(DiscountDependencyProvider::PLUGIN_DEFAULT_DISCOUNT_CREATE_CONFIGURATOR_EXPANDER);
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Facade\DiscountToLocaleFacadeInterface
     */
    public function getLocaleFacade(): DiscountToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(DiscountDependencyProvider::FACADE_LOCALE);
    }
}
