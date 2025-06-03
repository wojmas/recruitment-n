<?php

declare(strict_types=1);

namespace RecruitmentTasks\OrderNote\Model;

use Magento\Framework\Model\AbstractModel;
use RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote as ResourceModel;

/**
 * Order Note Model
 *
 * @method int getEntityId()
 * @method int getOrderId()
 * @method string|null getCustomOrderNote()
 * @method $this setOrderId(int $orderId)
 * @method $this setCustomOrderNote(?string $note)
 */
class OrderNote extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }
}
