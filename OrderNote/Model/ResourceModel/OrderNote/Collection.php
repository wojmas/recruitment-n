<?php

declare(strict_types=1);

namespace RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RecruitmentTasks\OrderNote\Model\OrderNote;
use RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote as ResourceModel;

/**
 * Order Note Collection
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
        $this->_init(OrderNote::class, ResourceModel::class);
    }
}
