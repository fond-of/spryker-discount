<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Facade;

interface DiscountCustomMessageToLocaleFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer[]
     */
    public function getLocaleCollection(): array;
}
