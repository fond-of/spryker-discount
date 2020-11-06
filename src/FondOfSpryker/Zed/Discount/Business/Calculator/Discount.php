<?php

namespace FondOfSpryker\Zed\Discount\Business\Calculator;

use ArrayObject;
use FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Discount\Business\Calculator\CalculatorInterface;
use Spryker\Zed\Discount\Business\Calculator\Discount as SprykerDiscount;
use Spryker\Zed\Discount\Business\Persistence\DiscountEntityMapperInterface;
use Spryker\Zed\Discount\Business\QueryString\SpecificationBuilderInterface;
use Spryker\Zed\Discount\Business\Voucher\VoucherValidatorInterface;
use Spryker\Zed\Discount\Dependency\Facade\DiscountToStoreFacadeInterface;
use Spryker\Zed\Discount\Persistence\DiscountQueryContainerInterface;

class Discount extends SprykerDiscount
{
    /**
     * @var \FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface
     */
    protected $customMessageConnectorPlugin;

    /**
     * @param \Spryker\Zed\Discount\Persistence\DiscountQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Discount\Business\Calculator\CalculatorInterface $calculator
     * @param \Spryker\Zed\Discount\Business\QueryString\SpecificationBuilderInterface $decisionRuleBuilder
     * @param \Spryker\Zed\Discount\Business\Voucher\VoucherValidatorInterface $voucherValidator
     * @param \Spryker\Zed\Discount\Business\Persistence\DiscountEntityMapperInterface $discountEntityMapper
     * @param \Spryker\Zed\Discount\Dependency\Facade\DiscountToStoreFacadeInterface $storeFacade
     * @param \FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface $customMessageConnectorPlugin
     */
    public function __construct(
        DiscountQueryContainerInterface $queryContainer,
        CalculatorInterface $calculator,
        SpecificationBuilderInterface $decisionRuleBuilder,
        VoucherValidatorInterface $voucherValidator,
        DiscountEntityMapperInterface $discountEntityMapper,
        DiscountToStoreFacadeInterface $storeFacade,
        CustomMessageConnectorPluginInterface $customMessageConnectorPlugin
    ) {
        parent::__construct(
            $queryContainer,
            $calculator,
            $decisionRuleBuilder,
            $voucherValidator,
            $discountEntityMapper,
            $storeFacade
        );

        $this->customMessageConnectorPlugin = $customMessageConnectorPlugin;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function calculate(QuoteTransfer $quoteTransfer)
    {
        $activeDiscounts = $this->retrieveActiveCartAndVoucherDiscounts(
            $this->getVoucherCodes($quoteTransfer),
            $this->getIdStore($quoteTransfer->getStore())
        );

        [$applicableDiscounts, $nonApplicableDiscounts] = $this->splitDiscountsByApplicability($activeDiscounts, $quoteTransfer);

        $collectedDiscounts = $this->calculator->calculate($applicableDiscounts, $quoteTransfer);

        $this->addDiscountsToQuote($quoteTransfer, $collectedDiscounts);
        $this->addNonApplicableDiscountsToQuote($quoteTransfer, $nonApplicableDiscounts);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer[] $nonApplicableDiscounts
     *
     * @return void
     */
    protected function addUnsuccessMessageForNonApplicableDiscounts(array $nonApplicableDiscounts, QuoteTransfer $quoteTransfer)
    {
        $discountIds = $this->getDiscountIds($quoteTransfer->getUsedNotAppliedDiscount());

        foreach ($nonApplicableDiscounts as $discountTransfer) {
            if (!in_array($discountTransfer->getIdDiscount(), $discountIds)) {
                $this->customMessageConnectorPlugin
                    ->addErrorMessage($discountTransfer);

                $quoteTransfer->addUsedNotAppliedDiscount($discountTransfer);
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\DiscountTransfer[] $discounts
     *
     * @return void
     */
    protected function addNonApplicableDiscountsToQuote(QuoteTransfer $quoteTransfer, array $discounts): void
    {
        $usedNotAppliedVoucherCodes = $quoteTransfer->getUsedNotAppliedVoucherCodes();

        foreach ($discounts as $discount) {
            if ($discount->getVoucherCode() && !in_array($discount->getVoucherCode(), $usedNotAppliedVoucherCodes)) {
                $quoteTransfer->addUsedNotAppliedVoucherCode($discount->getVoucherCode());
            }
        }
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\DiscountTransfer[] $discountTransferCollection
     *
     * @return array
     */
    protected function getDiscountIds(ArrayObject $discountTransferCollection): array
    {
        $discountIds = [];

        foreach ($discountTransferCollection as $discountTransfer) {
            if ($discountTransfer->getIdDiscount()) {
                $discountIds[] = $discountTransfer->getIdDiscount();
            }
        }

        return $discountIds;
    }
}
