<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Cron;

use Magento\Framework\Stdlib\DateTime\DateTime;
use RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory\Collection;
use RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory\CollectionFactory;
use RecruitmentTasks\ProductCustomSku\Model\RetentionConfig;

/**
 * Cleans old entries from Custom SKU history
 */
class CleanCustomSkuHistory
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly RetentionConfig $retentionConfig,
        private readonly DateTime $dateTime
    ) {}

    /**
     * Clean old entries from Custom SKU history table
     */
    public function execute(): void
    {
        $retentionDays = $this->retentionConfig->getRetentionPeriod();
        $threshold = $this->dateTime->gmtTimestamp() - ($retentionDays * 24 * 60 * 60);
        $thresholdDate = date('Y-m-d H:i:s', $threshold);

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('changed_at', ['lt' => $thresholdDate]);
        $collection->walk('delete');
    }
}
