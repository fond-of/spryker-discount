<?php

namespace FondOfSpryker\Zed\Discount\Dependency\Facade;

use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

class DiscountCustomMessageToLocaleFacadeBridge implements DiscountCustomMessageToLocaleFacadeInterface
{
    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    private $localeFacade;

    public function __construct(LocaleFacadeInterface $localeFacade)
    {
        $this->localeFacade = $localeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer[]
     */
    public function getLocaleCollection(): array
    {
        return $this->localeFacade->getLocaleCollection();
    }
}
