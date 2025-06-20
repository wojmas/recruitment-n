<?php

declare(strict_types=1);

namespace RecruitmentTasks\OrderNote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Order Note Resource Model
 */
class OrderNote extends AbstractDb
{
    /**
     * Table name
     */
    private const TABLE_NAME = 'recruitment_tasks_order_note';

    /**
     * Primary key field name
     */
    private const PRIMARY_KEY = 'entity_id';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}
