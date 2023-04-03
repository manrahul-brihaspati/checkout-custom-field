<?php

namespace Tbi\CheckoutCustomField\Plugin\Checkout\Model;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Checkout\Api\Data\ShippingInformationInterface;

class ShippingInformationManagement
{

    private $_addressInformation;
    public $cartRepository;

    public function __construct(
        ShippingInformationInterface $addressInformation,
        CartRepositoryInterface $cartRepository
        
    ) {
        $this->_addressInformation = $addressInformation;
        $this->cartRepository = $cartRepository;
    }

    public function beforeSaveAddressInformation($subject, $cartId, $addressInformation)
    {
        $quote = $this->cartRepository->getActive($cartId);
        $deliveryType = $addressInformation->getShippingAddress();
        $extAttributes = $this->_addressInformation->getExtensionAttributes();
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/delivery_type.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($extAttributes),true);
        $logger->info('Tbi\DeliveryType\Plugin\Quote\ShippingInformationManagement From <=');

        $quote->setDeliveryType($deliveryType);
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];
    }
}