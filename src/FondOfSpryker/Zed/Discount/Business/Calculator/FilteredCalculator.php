<?php

namespace FondOfSpryker\Zed\Discount\Business\Calculator;

use FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Discount\Business\Calculator\FilteredCalculator as SprykerFilteredCalculator;
use Spryker\Zed\Discount\Business\Distributor\DistributorInterface;
use Spryker\Zed\Discount\Business\Filter\DiscountableItemFilterInterface;
use Spryker\Zed\Discount\Business\QueryString\SpecificationBuilderInterface;
use Spryker\Zed\Discount\Dependency\Facade\DiscountToMessengerInterface;

class FilteredCalculator extends SprykerFilteredCalculator
{
    /**
     * @var \FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface
     */
    protected $messageConnectorPlugin;

    /**
     * @param \Spryker\Zed\Discount\Business\QueryString\SpecificationBuilderInterface $collectorBuilder
     * @param \Spryker\Zed\Discount\Dependency\Facade\DiscountToMessengerInterface $messengerFacade
     * @param \Spryker\Zed\Discount\Business\Distributor\DistributorInterface $distributor
     * @param \Spryker\Zed\Discount\Dependency\Plugin\DiscountCalculatorPluginInterface[]|\Spryker\Zed\Discount\Dependency\Plugin\DiscountAmountCalculatorPluginInterface[] $calculatorPlugins
     * @param \Spryker\Zed\DiscountExtension\Dependency\Plugin\CollectedDiscountGroupingStrategyPluginInterface[] $collectedDiscountGroupingPlugins
     * @param \Spryker\Zed\Discount\Business\Filter\DiscountableItemFilterInterface $discountableItemFilter
     */
    public function __construct(
        SpecificationBuilderInterface $collectorBuilder,
        DiscountToMessengerInterface $messengerFacade,
        DistributorInterface $distributor,
        array $calculatorPlugins,
        array $collectedDiscountGroupingPlugins,
        DiscountableItemFilterInterface $discountableItemFilter,
        CustomMessageConnectorPluginInterface $messageConnectorPlugin
    ) {
        parent::__construct($collectorBuilder, $messengerFacade, $distributor, $calculatorPlugins, $collectedDiscountGroupingPlugins, $discountableItemFilter);

        $this->messageConnectorPlugin = $messageConnectorPlugin;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer[] $discounts
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\CollectedDiscountTransfer[]
     */
    public function calculate(array $discounts, QuoteTransfer $quoteTransfer)
    {
        $collectedDiscountTransfers = $this->calculateDiscountAmount($discounts, $quoteTransfer);
        $collectedDiscountTransferGroups = $this->groupCollectedDiscounts($collectedDiscountTransfers);

        $collectedDiscountTransfers = [];
        foreach ($collectedDiscountTransferGroups as $collectedDiscountTransfersGroup) {
            $collectedDiscountTransfersGroup = $this->sortByDiscountAmountDescending($collectedDiscountTransfersGroup);
            $collectedDiscountTransfersGroup = $this->filterExclusiveDiscounts($collectedDiscountTransfersGroup);
            $collectedDiscountTransfers = array_merge($collectedDiscountTransfers, $collectedDiscountTransfersGroup);
        }

        $this->distributeDiscountAmount($collectedDiscountTransfers);

        $this->addDiscountsAppliedMessage(
            $collectedDiscountTransfers,
            $quoteTransfer->getCartRuleDiscounts(),
            $quoteTransfer->getVoucherDiscounts()
        );

        return $collectedDiscountTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     *
     * @return void
     */
    protected function setSuccessfulDiscountAddMessage(DiscountTransfer $discountTransfer): void
    {
        if (!$discountTransfer->getAmount()) {
            return;
        }

        $this->messageConnectorPlugin->addSuccessMessage($discountTransfer);
    }
}
