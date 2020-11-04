<?php

namespace FondOfSpryker\Zed\Discount\Business;

use FondOfSpryker\Zed\Discount\Business\Calculator\Discount;
use FondOfSpryker\Zed\Discount\Business\Calculator\FilteredCalculator;
use FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface;
use FondOfSpryker\Zed\Discount\DiscountDependencyProvider;
use Spryker\Zed\Discount\Business\DiscountBusinessFactory as SprykerDiscountBusinessFactory;

class DiscountBusinessFactory extends SprykerDiscountBusinessFactory
{
    /**
     * @return \Spryker\Zed\Discount\Business\Calculator\DiscountInterface
     */
    public function createDiscount()
    {
        $discount = new Discount(
            $this->getQueryContainer(),
            $this->createCalculator(),
            $this->createDecisionRuleBuilder(),
            $this->createVoucherValidator(),
            $this->createDiscountEntityMapper(),
            $this->getStoreFacade(),
            $this->getMessageConnectorPlugin()
        );

        $discount->setDiscountApplicableFilterPlugins($this->getDiscountApplicableFilterPlugins());

        return $discount;
    }

    /**
     * @return \Spryker\Zed\Discount\Business\Calculator\CalculatorInterface
     */
    protected function createCalculator()
    {
        $calculator = new FilteredCalculator(
            $this->createCollectorBuilder(),
            $this->getMessengerFacade(),
            $this->createDistributor(),
            $this->getCalculatorPlugins(),
            $this->getCollectedDiscountGroupingPlugins(),
            $this->createDiscountableItemFilter(),
            $this->getMessageConnectorPlugin()
        );

        $calculator->setCollectorStrategyResolver($this->createCollectorResolver());

        return $calculator;
    }

    /**
     * @return \FondOfSpryker\Zed\Discount\Dependency\Calculator\CustomMessageConnectorPluginInterface
     */
    public function getMessageConnectorPlugin(): CustomMessageConnectorPluginInterface
    {
        return $this->getProvidedDependency(DiscountDependencyProvider::PLUGIN_CUSTOM_MESSAGE_CONNECTOR_PLUGIN);
    }
}
