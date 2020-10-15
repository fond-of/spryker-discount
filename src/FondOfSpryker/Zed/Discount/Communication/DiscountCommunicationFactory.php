<?php

namespace FondOfSpryker\Zed\Discount\Communication;

use FondOfSpryker\Zed\Discount\Communication\Form\DataProvider\DiscountFormDataProvider;
use FondOfSpryker\Zed\Discount\DiscountDependencyProvider;
use Spryker\Zed\Discount\Communication\DiscountCommunicationFactory as SprykerDiscountCommunicationFactory;

/**
 * @method \Spryker\Zed\Discount\Business\DiscountFacadeInterface getFacade()
 */
class DiscountCommunicationFactory extends SprykerDiscountCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Discount\Communication\Form\DataProvider\DiscountFormDataProvider
     */
    public function createDiscountFormDataProvider()
    {
        $discountFormDataProvider = new DiscountFormDataProvider($this->getFacade());

        $discountFormDataProvider->applyFormDataExpanderPlugins($this->getDiscountFormDataProviderExpanderPlugins());

        return $discountFormDataProvider;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Plugin\Form\DiscountFormDataProviderExpanderPluginInterface[]
     */
    public function getDiscountFormDataProviderExpanderPlugins(): array
    {
        return $this->getProvidedDependency(DiscountDependencyProvider::PLUGIN_DISCOUNT_FORM_DATA_PROVIDER_EXPANDER);
    }
}
