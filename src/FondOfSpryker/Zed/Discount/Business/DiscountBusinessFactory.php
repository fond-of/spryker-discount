<?php

namespace FondOfSpryker\Zed\Discount\Business;

use FondOfSpryker\Zed\Discount\Business\Persistence\DiscountPersist;
use FondOfSpryker\Zed\Discount\DiscountDependencyProvider;
use Spryker\Zed\Discount\Business\DiscountBusinessFactory as SprykerDiscountBusinessFactory;

class DiscountBusinessFactory extends SprykerDiscountBusinessFactory
{
    /**
     * @return \Spryker\Zed\Discount\Business\Persistence\DiscountPersistInterface
     */
    public function createDiscountPersist()
    {
        $discountPersist = new DiscountPersist(
            $this->createVoucherEngine(),
            $this->getQueryContainer(),
            $this->createDiscountStoreRelationWriter(),
            $this->getDiscountPostCreatePlugins(),
            $this->getDiscountPostUpdatePlugins(),
            $this->getDiscountEntityHydratorPlugins()
        );

        return $discountPersist;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Persistence\DiscountEntityHydratorPluginInterface[]
     */
    public function getDiscountEntityHydratorPlugins(): array
    {
        return $this->getProvidedDependency(DiscountDependencyProvider::PLUGIN_DISCOUNT_ENTITY_HYDRATOR);
    }
}
