<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Persistence;

use Generated\Shared\Transfer\DiscountConfiguratorTransfer;
use Orm\Zed\Discount\Persistence\SpyDiscount;

interface DiscountEntityHydratorPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DiscountConfiguratorTransfer $discountConfiguratorTransfer
     * @param \Orm\Zed\Discount\Persistence\SpyDiscount $discountEntity
     *
     * @return \Generated\Shared\Transfer\DiscountConfiguratorTransfer
     */
    public function hydrateDiscountEntity(
        DiscountConfiguratorTransfer $discountConfiguratorTransfer,
        SpyDiscount $discountEntity
    ): DiscountConfiguratorTransfer;
}
