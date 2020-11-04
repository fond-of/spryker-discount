<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Calculator;

use Generated\Shared\Transfer\DiscountTransfer;

interface CustomMessageConnectorPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     *
     * @retun void
     */
    public function addSuccessMessage(DiscountTransfer $discountTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     *
     * @return void
     */
    public function addErrorMessage(DiscountTransfer $discountTransfer): void;
}
