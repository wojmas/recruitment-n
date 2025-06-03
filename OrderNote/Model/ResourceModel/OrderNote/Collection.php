<?php
declare(strict_types=1);
namespace RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \RecruitmentTasks\OrderNote\Model\OrderNote::class,
            \RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote::class
        );
    }
}
