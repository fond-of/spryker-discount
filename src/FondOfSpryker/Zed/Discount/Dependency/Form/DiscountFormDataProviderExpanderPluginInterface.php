<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Plugin\Form;

use Generated\Shared\Transfer\DiscountConfiguratorTransfer;
use Spryker\Zed\Discount\Dependency\Plugin\Form\DiscountFormDataProviderExpanderPluginInterface as SprykerDiscountFormDataProviderExpanderPluginInterface;

interface DiscountFormDataProviderExpanderPluginInterface extends SprykerDiscountFormDataProviderExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DiscountConfiguratorTransfer $discountConfiguratorTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountConfiguratorTransfer
     */
    public function expandData(DiscountConfiguratorTransfer $discountConfiguratorTransfer): DiscountConfiguratorTransfer;
}
