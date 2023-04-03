<?php

namespace Tbi\CheckoutCustomField\Plugin\Checkout\Model;

use Magento\Quote\Api\CartRepositoryInterface;

class ShippingInformationManagement
{
    public $cartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartRepository = $cartRepository;
    }

    public function beforeSaveAddressInformation($subject, $cartId, $addressInformation)
    {
        $quote = $this->cartRepository->getActive($cartId);
        $deliveryType = $addressInformation->getShippingAddress();
        
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/delivery_type.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($addressInformation->getCustomAttributes()),true);
        $logger->info('Tbi\DeliveryType\Plugin\Quote\ShippingInformationManagement From <=');

        $quote->setDeliveryType($deliveryType);
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];
    }
}