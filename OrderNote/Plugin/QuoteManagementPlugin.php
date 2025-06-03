<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderNote\Plugin;

use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Quote\Model\Quote;
use Psr\Log\LoggerInterface;
use RecruitmentTasks\OrderNote\Model\OrderNoteFactory;
use RecruitmentTasks\OrderNote\Model\ResourceModel\OrderNote as OrderNoteResource;

class QuoteManagementPlugin
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly OrderNoteFactory $orderNoteFactory,
        private readonly OrderNoteResource $orderNoteResource
    ) {
    }

    /**
     * Saves custom order note from quote shipping address to order after order submission
     *
     * @todo Investigate potential multiple order notes scenario and implement proper handling
     */
    public function afterSubmit(
        QuoteManagement $subject,
        ?OrderInterface $result,
        Quote $quote
    ): ?OrderInterface {
        if (!$result) {
            return $result;
        }

        try {
            $shippingAddress = $quote->getShippingAddress();
            if ($shippingAddress && $shippingAddress->getCustomOrderNote()) {
                $orderNote = $this->orderNoteFactory->create();
                $orderNote->setOrderId((int)$result->getEntityId());
                $orderNote->setCustomOrderNote($shippingAddress->getCustomOrderNote());
                $this->orderNoteResource->save($orderNote);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while saving order note: ' . $e->getMessage());
        }

        return $result;
    }
}
