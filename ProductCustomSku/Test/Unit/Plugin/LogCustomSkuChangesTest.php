<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Test\Unit\Plugin;

use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\User\Model\User;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use PHPUnit\Framework\TestCase;
use RecruitmentTasks\ProductCustomSku\Model\CustomSkuHistory;
use RecruitmentTasks\ProductCustomSku\Model\CustomSkuHistoryFactory;
use RecruitmentTasks\ProductCustomSku\Model\ResourceModel\CustomSkuHistory as CustomSkuHistoryResource;
use RecruitmentTasks\ProductCustomSku\Plugin\LogCustomSkuChanges;
use RecruitmentTasks\ProductCustomSku\Setup\Patch\Data\AddCustomSkuAttribute;

// just added sample unit test wasn't running it might fail
class LogCustomSkuChangesTest extends TestCase
{
    private LogCustomSkuChanges $plugin;
    private CustomSkuHistoryFactory $historyFactoryMock;
    private CustomSkuHistoryResource $historyResourceMock;
    private AuthSession $authSessionMock;
    private ProductResource $productResourceMock;
    private Product $productMock;

    protected function setUp(): void
    {
        $this->historyFactoryMock = $this->createMock(CustomSkuHistoryFactory::class);
        $this->historyResourceMock = $this->createMock(CustomSkuHistoryResource::class);
        $this->authSessionMock = $this->getMockBuilder(AuthSession::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__call'])
            ->getMock();
        $this->productResourceMock = $this->createMock(ProductResource::class);
        $this->productMock = $this->createMock(Product::class);

        $this->plugin = new LogCustomSkuChanges(
            $this->historyFactoryMock,
            $this->historyResourceMock,
            $this->authSessionMock
        );
    }

    public function testBeforeSaveWithCustomSkuChange(): void
    {
        $userId = 1;
        $productId = 123;
        $oldValue = 'OLD-SKU';
        $newValue = 'NEW-SKU';

        $userMock = $this->createMock(User::class);
        $userMock->method('getId')->willReturn($userId);

        $this->authSessionMock->method('__call')
            ->with('getUser', [])
            ->willReturn($userMock);

        $historyMock = $this->createMock(CustomSkuHistory::class);

        $this->productMock->expects($this->once())
            ->method('hasDataChanges')
            ->willReturn(true);
        $this->productMock->expects($this->once())
            ->method('getAttributeSetId')
            ->willReturn(4);
        $this->productMock->expects($this->once())
            ->method('getStoreId')
            ->willReturn(0);
        $this->productMock->expects($this->once())
            ->method('getId')
            ->willReturn($productId);
        $this->productMock->expects($this->once())
            ->method('getOrigData')
            ->with(AddCustomSkuAttribute::CUSTOM_SKU_ATTRIBUTE)
            ->willReturn($oldValue);
        $this->productMock->expects($this->once())
            ->method('getData')
            ->with(AddCustomSkuAttribute::CUSTOM_SKU_ATTRIBUTE)
            ->willReturn($newValue);

        $this->historyFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($historyMock);

        $expectedData = [
            'product_id' => $productId,
            'old_value' => $oldValue,
            'user_id' => $userId
        ];

        $historyMock->expects($this->once())
            ->method('setData')
            ->with($expectedData);

        $this->historyResourceMock->expects($this->once())
            ->method('save')
            ->with($historyMock);

        $result = $this->plugin->beforeSave($this->productResourceMock, $this->productMock);
        $this->assertSame([$this->productMock], $result);
    }
}
