<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Provides retention configuration for Custom SKU history
 */
class RetentionConfig
{
    private const XML_PATH_RETENTION_PERIOD = 'catalog/custom_sku/retention_period';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {}

    /**
     * Get number of days to keep Custom SKU changes in history
     */
    public function getRetentionPeriod(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_RETENTION_PERIOD,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
    }
}
