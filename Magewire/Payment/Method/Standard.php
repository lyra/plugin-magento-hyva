<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Hyvä Compatibility module for PayZen. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Lyranetwork\PayzenHyva\Magewire\Payment\Method;

use Magento\Checkout\Model\Session;
use Magento\Quote\Api\CartRepositoryInterface;
use Magewirephp\Magewire\Component;
use \Lyranetwork\Payzen\Model\StandardConfigProvider as ConfigProvider;
use \Lyranetwork\Payzen\Helper\Data as Data;

class Standard extends Payzen
{
    private $dataHelper;
    private $method;

    protected $eventManager;

    public function __construct(
        Session $checkoutSession,
        CartRepositoryInterface $cartRepository,
        ConfigProvider $configProvider,
        Data $dataHelper,
        \Lyranetwork\Payzen\Model\Method\Standard $method,
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        parent::__construct($checkoutSession, $cartRepository, $configProvider, Data::METHOD_STANDARD);

        $this->dataHelper = $dataHelper;
        $this->method = $method;
        $this->eventManager = $eventManager;
    }

    public function setOrderToken(): array
    {
        $checkout = $this->dataHelper->getCheckout();

        // Create token from order data.
        $lastIncrementId = $checkout->getData(Data::LAST_REAL_ID);
        if ($lastIncrementId) {
            $order = $this->dataHelper->getOrderByIncrementId($lastIncrementId);
        } else {
            $orderId = $this->dataHelper->getCheckout()->getLastOrderId();
            $order = $orderId ? $this->dataHelper->getOrderById($orderId) : null;
        }

        if (! $order) {
            return $this->paymentData;
        }

        $this->paymentData['restFormToken'] = $this->method->getTokenForOrder($order);

        return $this->paymentData;
    }

    public function restoreCart(): void
    {
        $checkout = $this->dataHelper->getCheckout();
        $lastIncrementId = $checkout->getData(Data::LAST_REAL_ID);
        if (! $lastIncrementId) {
            return;
        }

        $order = $this->dataHelper->getOrderByIncrementId($lastIncrementId);
        $quote = $this->cartRepository->get($order->getQuoteId());

        if ($quote->getId() && ! $quote->getIsActive() && ($this->method->getConfigData('rest_attempts') !== '0')) {
            $checkout->setData(Data::LAST_REAL_ID, null);

            $this->dataHelper->log("Restore cart for order #{$order->getIncrementId()} to allow more payment attempts.");
            $quote->setIsActive(true)->setReservedOrderId(null);
            $this->cartRepository->save($quote);

            // To comply with Magento\Checkout\Model\Session::restoreQuote() method.
            $checkout->replaceQuote($quote)->unsLastRealOrderId();
            $this->eventManager->dispatch('restore_quote', ['order' => $order, 'quote' => $quote]);
        }
    }

    public function setLogSrc($src)
    {
        $this->dataHelper->log("PlaceOrderClick() function has been called from source [{$src}].");
    }

    public function getPaymentData(string $method): array
    {
        $this->paymentData = parent::getPaymentData($method);
        $restModes = [Data::MODE_SMARTFORM, Data::MODE_SMARTFORM_EXT_WITH_LOGOS, Data::MODE_SMARTFORM_EXT_WITHOUT_LOGOS];
        if (! in_array($this->paymentData['entryMode'], $restModes)) {
            return $this->paymentData;
        }

        $this->paymentData['customerWallet'] = '0';
        $quote = $this->dataHelper->getCheckoutQuote();

        if (! isset($this->paymentData['restFormToken'])) {
            $isTest = $this->dataHelper->getCommonConfigData('ctx_mode') === 'TEST';

            if ($isTest && ($msg = $quote->getPayment()->getAdditionalInformation(\Lyranetwork\Payzen\Helper\Payment::REST_ERROR_MESSAGE))) {
                $errorMessage = $msg . __(' Please consult the documentation for more details.');
            } else {
                $errorMessage = __('Something went wrong while processing your payment request. Please try again later.');
            }

            $this->paymentData['errorMessage'] = $errorMessage;
        } else {
            if ($this->method->isOneClickActive() && $quote->getCustomerId()) {
                $this->paymentData['customerWallet'] = '1';
            }
        }

        return $this->paymentData;
    }
}