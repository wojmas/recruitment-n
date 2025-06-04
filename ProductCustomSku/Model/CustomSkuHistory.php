<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Model;

use Magento\Framework\Model\AbstractModel;
use RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory as ResourceModel;

/**
 * Custom SKU History Model
 *
 * @method int getEntityId()
 * @method int getProductId()
 * @method string|null getOldValue()
 * @method string getChangedAt()
 * @method int|null getUserId()
 * @method $this setProductId(int $productId)
 * @method $this setOldValue(?string $oldValue)
 * @method $this setUserId(?int $userId)
 */
class CustomSkuHistory extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }
}
