<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Plugin;

use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Framework\Model\AbstractModel;
use Magento\Backend\Model\Auth\Session as AuthSession;
use RecruitmentTasks\ProductCustomSku\Model\CustomSkuHistoryFactory;
use RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory as CustomSkuHistoryResource;
use RecruitmentTasks\ProductCustomSku\Setup\Patch\Data\AddCustomSkuAttribute;

/**
 * Logs changes of custom_sku attribute for products in global scope
 *
 * @see \Magento\Catalog\Model\ResourceModel\Product::save()
 */
class LogCustomSkuChanges
{
    public function __construct(
        private readonly CustomSkuHistoryFactory $historyFactory,
        private readonly CustomSkuHistoryResource $historyResource,
        private readonly AuthSession $authSession
    ) {}

    /**
     * Saves history record when custom_sku value changes in global scope
     *
     * @param Product $subject
     * @param AbstractModel $product
     * @return array{0: AbstractModel}
     */
    public function beforeSave(Product $subject, AbstractModel $product): array
    {
        if (!$product->hasDataChanges()) {
            return [$product];
        }

        if ($product->getAttributeSetId() && $product->getStoreId() === 0) {
            $oldValue = $product->getOrigData(AddCustomSkuAttribute::CUSTOM_SKU_ATTRIBUTE);
            $newValue = $product->getData(AddCustomSkuAttribute::CUSTOM_SKU_ATTRIBUTE);

            if ($oldValue !== $newValue) {
                $history = $this->historyFactory->create();
                $history->setData([
                    'product_id' => (int)$product->getId(),
                    'old_value' => $oldValue,
                    'user_id' => $this->authSession->getUser()?->getId() ?? 0
                ]);

                $this->historyResource->save($history);
            }
        }

        return [$product];
    }
}
