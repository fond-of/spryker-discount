<?php

namespace FondOfSpryker\Zed\Discount\Business\Persistence;

use Generated\Shared\Transfer\DiscountConfiguratorTransfer;
use Orm\Zed\Discount\Persistence\SpyDiscount;
use Spryker\Zed\Discount\Business\Persistence\DiscountPersist as SprykerDiscountPersist;
use Spryker\Zed\Discount\Business\Persistence\DiscountStoreRelationWriterInterface;
use Spryker\Zed\Discount\Business\Voucher\VoucherEngineInterface;
use Spryker\Zed\Discount\Persistence\DiscountQueryContainerInterface;

class DiscountPersist extends SprykerDiscountPersist
{
    /**
     * @var \FondOfSpryker\Zed\Discount\Dependency\Persistence\DiscountEntityHydratorPluginInterface[]
     */
    protected $discountEntityHydratorPlugins;

    /**
     * @param \Spryker\Zed\Discount\Business\Voucher\VoucherEngineInterface $voucherEngine
     * @param \Spryker\Zed\Discount\Persistence\DiscountQueryContainerInterface $discountQueryContainer
     * @param \Spryker\Zed\Discount\Business\Persistence\DiscountStoreRelationWriterInterface $discountStoreRelationWriter
     * @param \Spryker\Zed\Discount\Dependency\Plugin\DiscountPostCreatePluginInterface[] $discountPostCreatePlugins
     * @param \Spryker\Zed\Discount\Dependency\Plugin\DiscountPostUpdatePluginInterface[] $discountPostUpdatePlugins
     * @param \FondOfSpryker\Zed\Discount\Dependency\Persistence\DiscountEntityHydratorPluginInterface[] $discountEntityHydratorPlugins
     */
    public function __construct(
        VoucherEngineInterface $voucherEngine,
        DiscountQueryContainerInterface $discountQueryContainer,
        DiscountStoreRelationWriterInterface $discountStoreRelationWriter,
        array $discountPostCreatePlugins,
        array $discountPostUpdatePlugins,
        array $discountEntityHydratorPlugins
    ) {
        parent::__construct(
            $voucherEngine,
            $discountQueryContainer,
            $discountStoreRelationWriter,
            $discountPostCreatePlugins,
            $discountPostUpdatePlugins
        );

        $this->discountEntityHydratorPlugins = $discountEntityHydratorPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountConfiguratorTransfer $discountConfiguratorTransfer
     *
     * @return int
     */
    public function save(DiscountConfiguratorTransfer $discountConfiguratorTransfer)
    {
        $discountEntity = $this->createDiscountEntity();
        $this->hydrateDiscountEntity($discountConfiguratorTransfer, $discountEntity);

        $this->handleDatabaseTransaction(function () use ($discountEntity, $discountConfiguratorTransfer) {
            $this->executeSaveDiscountTransaction($discountEntity, $discountConfiguratorTransfer);
        });

        return $discountEntity->getIdDiscount();
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountConfiguratorTransfer $discountConfiguratorTransfer
     * @param \Orm\Zed\Discount\Persistence\SpyDiscount $discountEntity
     *
     * @return void
     */
    protected function hydrateDiscountEntity(
        DiscountConfiguratorTransfer $discountConfiguratorTransfer,
        SpyDiscount $discountEntity
    ): void {
        parent::hydrateDiscountEntity($discountConfiguratorTransfer, $discountEntity);

        foreach ($this->discountEntityHydratorPlugins as $plugin) {
            $plugin->hydrateDiscountEntity($discountConfiguratorTransfer, $discountEntity);
        }
    }
}
