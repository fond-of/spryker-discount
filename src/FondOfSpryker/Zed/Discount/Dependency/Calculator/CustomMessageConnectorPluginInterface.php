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
    public function addSuccessMessageFromDiscountTransfer(DiscountTransfer $discountTransfer): void;

    /**
     * @param string $successMessage
     */
    public function addSuccessMessageFromString(string $successMessage): void;

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     *
     * @return void
     */
    public function addErrorMessageFromDiscountTransfer(DiscountTransfer $discountTransfer): void;

    /**
     * @param string $errorMessage
     */
    public function addVoucherNotFoundErrorMessage(): void;
}
