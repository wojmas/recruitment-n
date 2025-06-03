<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Patch for installing custom_sku product attribute
 */
class AddCustomSkuAttribute implements DataPatchInterface
{
    /**
     * Custom SKU attribute code
     */
    public const CUSTOM_SKU_ATTRIBUTE = 'custom_sku';

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory $eavSetupFactory
    ) {}

    /**
     * Adds custom_sku attribute to product entity
     *
     * @return void
     */
    public function apply(): void
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::CUSTOM_SKU_ATTRIBUTE,
            [
                'type' => 'varchar',
                'length' => '128',
                'label' => 'Custom SKU',
                'input' => 'text',
                'required' => false,
                'sort_order' => 21,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'user_defined' => true,
                'searchable' => true,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => true,
                'group' => 'General'
            ]
        );
    }

    /**
     * Dependencies for this patch
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Aliases for this patch
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
