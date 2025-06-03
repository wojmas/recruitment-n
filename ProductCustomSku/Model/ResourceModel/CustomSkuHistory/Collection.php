<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RecruitmentTasks\ProductCustomSku\Model\CustomSkuHistory;
use RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory as ResourceModel;

/**
 * Custom SKU History Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize collection model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(CustomSkuHistory::class, ResourceModel::class);
    }
}
