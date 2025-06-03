<?php
declare(strict_types=1);
namespace RecruitmentTasks\OrderNote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderNote extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('recruitment_tasks_order_note', 'entity_id');
    }
}
