<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Calculator;

use Generated\Shared\Transfer\DiscountTransfer;

interface CustomMessageConnectorPluginInterface
{
    /**
     * @retun void
     *
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     */
    public function addSuccessMessage(DiscountTransfer $discountTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     *
     * @return void
     */
    public function addErrorMessage(DiscountTransfer $discountTransfer): void;
}
