<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderNote\Plugin;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Plugin responsible for handling custom order notes during shipping information save process
 */
class ShippingInformationManagementPlugin
{
    /**
     * @param CartRepositoryInterface $cartRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Save custom order note to quote shipping address
     *
     * @param ShippingInformationManagement $subject
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return array
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
                                      $cartId,
        ShippingInformationInterface $addressInformation
    ): array {
        try {
            $shippingAddress = $addressInformation->getShippingAddress();
            $extensionAttributes = $shippingAddress->getExtensionAttributes();
            $note = $extensionAttributes?->getCustomOrderNote();

            if ($note !== null) {
                $quote = $this->cartRepository->getActive($cartId);
                $quoteShippingAddress = $quote->getShippingAddress();
                $quoteShippingAddress->setCustomOrderNote($note);
                $this->cartRepository->save($quote);
            }
        } catch (\Exception $e) {
            $this->logger->error(
                'Error while saving custom_order_note to quote_address: ' . $e->getMessage(),
                ['exception' => $e]
            );
        }

        return [$cartId, $addressInformation];
    }
}
