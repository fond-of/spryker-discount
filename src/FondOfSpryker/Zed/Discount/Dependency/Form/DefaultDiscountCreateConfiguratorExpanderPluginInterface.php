<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Form;

use Generated\Shared\Transfer\DiscountConfiguratorTransfer;

interface DefaultDiscountCreateConfiguratorExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DiscountConfiguratorTransfer $discountConfiguratorTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountConfiguratorTransfer
     */
    public function expandDefaultDiscountConfigurator(DiscountConfiguratorTransfer $discountConfiguratorTransfer): DiscountConfiguratorTransfer;
}
