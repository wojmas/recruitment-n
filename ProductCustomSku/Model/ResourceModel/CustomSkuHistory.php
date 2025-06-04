<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Custom SKU History Resource Model
 */
class CustomSkuHistory extends AbstractDb
{
    /**
     * Table name
     */
    private const TABLE_NAME = 'recruitment_tasks_custom_sku_history';

    /**
     * Primary key field name
     */
    private const PRIMARY_KEY = 'entity_id';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}
