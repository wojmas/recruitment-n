<?php
declare(strict_types=1);
namespace RecruitmentTasks\OrderNote\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class OrderNote extends AbstractModel
{
    /**
     * @return void
     * @throws LocalizedException
     */
    protected function _construct()
    {
        $this->_init(\RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote::class);
    }
}
