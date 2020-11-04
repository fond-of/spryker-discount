<?php

namespace FondOfSpryker\Zed\Discount\Communication\Form\DataProvider;

use Generated\Shared\Transfer\DiscountConfiguratorTransfer;
use Spryker\Zed\Discount\Business\DiscountFacadeInterface;
use Spryker\Zed\Discount\Communication\Form\DataProvider\DiscountFormDataProvider as SprykerDiscountFormDataProvider;

class DiscountFormDataProvider extends SprykerDiscountFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\Discount\Dependency\Form\DefaultDiscountCreateConfiguratorExpanderPluginInterface[]
     */
    protected $discountFormDataProviderExpanderPlugins;

    /**
     * @param \Spryker\Zed\Discount\Business\DiscountFacadeInterface $discountFacade
     * @param \FondOfSpryker\Zed\Discount\Dependency\Form\DefaultDiscountCreateConfiguratorExpanderPluginInterface[] $discountFormDataProviderExpanderPlugins
     */
    public function __construct(
        DiscountFacadeInterface $discountFacade,
        array $discountFormDataProviderExpanderPlugins = []
    ) {
        parent::__construct($discountFacade);

        $this->discountFormDataProviderExpanderPlugins = $discountFormDataProviderExpanderPlugins;
    }

    /**
     * @param null $idDiscount
     *
     * @return \Generated\Shared\Transfer\DiscountConfiguratorTransfer|null
     */
    public function getData($idDiscount = null): ?DiscountConfiguratorTransfer
    {
        if ($idDiscount === null) {
            return $this->createDefaultDiscountConfiguratorTransfer();
        }

        return $this->discountFacade->findHydratedDiscountConfiguratorByIdDiscount($idDiscount);
    }

    /**
     * @return \Generated\Shared\Transfer\DiscountConfiguratorTransfer
     */
    protected function createDefaultDiscountConfiguratorTransfer(): DiscountConfiguratorTransfer
    {
        $discountConfiguratorTransfer = parent::createDefaultDiscountConfiguratorTransfer();
        $discountConfiguratorTransfer = $this->executeFormDataProviderPlugins($discountConfiguratorTransfer);

        return $discountConfiguratorTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountConfiguratorTransfer $discountConfiguratorTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountConfiguratorTransfer
     */
    protected function executeFormDataProviderPlugins(
        DiscountConfiguratorTransfer $discountConfiguratorTransfer
    ): DiscountConfiguratorTransfer {
        foreach ($this->discountFormDataProviderExpanderPlugins as $dataProviderExpanderPlugin) {
            $discountConfiguratorTransfer = $dataProviderExpanderPlugin->expandDefaultDiscountConfigurator($discountConfiguratorTransfer);
        }

        return $discountConfiguratorTransfer;
    }
}
