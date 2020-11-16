<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface DiscountToLocaleFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale(): LocaleTransfer;
}
