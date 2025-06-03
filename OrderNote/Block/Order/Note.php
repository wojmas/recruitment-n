<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderNote\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Block\Order\View;
use Magento\Sales\Model\Order;
use RecruitmentTasks\OrderNote\Model\OrderNoteFactory;
use RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote as OrderNoteResource;

class Note extends Template
{
    /**
     * @param Context $context
     * @param OrderNoteFactory $orderNoteFactory
     * @param OrderNoteResource $orderNoteResource
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        private OrderNoteFactory $orderNoteFactory,
        private OrderNoteResource $orderNoteResource,
        private Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get order note for frontend display
     *
     * @return string|null
     */
    public function getFrontendOrderNote(): ?string
    {
        $order = $this->getFrontendOrder();
        if (!$order) {
            return null;
        }
        $orderId = $order->getId();
        return $orderId ? $this->loadOrderNote($orderId) : null;
    }

    /**
     * Get order note for admin display
     *
     * @return string|null
     */
    public function getAdminOrderNote(): ?string
    {
        $order = $this->getAdminOrder();
        if (!$order) {
            return null;
        }
        $orderId = $order->getId();
        return $orderId ? $this->loadOrderNote($orderId) : null;
    }

    /**
     * Get order for frontend area
     *
     * @return Order|null
     */
    private function getFrontendOrder(): ?Order
    {
        /** @var View $orderBlock */
        $orderBlock = $this->getLayout()->getBlock('sales.order.view');
        return $orderBlock ? $orderBlock->getOrder() : null;
    }

    /**
     * Get order for admin area
     *
     * @return Order|null
     */
    private function getAdminOrder(): ?Order
    {
        return $this->registry->registry('current_order');
    }

    /**
     * Load order note by order ID
     *
     * @param int|null $orderId
     * @return string|null
     */
    private function loadOrderNote($orderId): ?string
    {
        if (!$orderId) {
            return null;
        }
        $orderNote = $this->orderNoteFactory->create();
        $this->orderNoteResource->load($orderNote, $orderId, 'order_id');
        return $orderNote->getCustomOrderNote();
    }
}
