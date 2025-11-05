<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Hyvä Compatibility module for PayZen. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Lyranetwork\PayzenHyva\Model\Magewire\Payment;

use Exception;
use Hyva\Checkout\Model\Magewire\Component\EvaluationInterface;
use Hyva\Checkout\Model\Magewire\Component\EvaluationResultFactory;
use Hyva\Checkout\Model\Magewire\Component\EvaluationResultInterface;
use Hyva\Checkout\Model\Magewire\Payment\AbstractPlaceOrderService;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Message\MessageInterface;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Model\Quote;
use Magewirephp\Magewire\Component;

class PayzenPlaceOrderService extends AbstractPlaceOrderService
{
    private Session $checkoutSession;
    private $dataHelper;

    public function __construct(
        CartManagementInterface $cartManagement,
        Session $checkoutSession,
        \Lyranetwork\Payzen\Helper\Data $dataHelper
    ) {
        parent::__construct($cartManagement);

        $this->checkoutSession = $checkoutSession;
        $this->dataHelper = $dataHelper;
    }

    public function canRedirect(): bool
    {
        $paymentMethod = $this->checkoutSession->getQuote()->getPayment()->getMethod();
        $method = $this->dataHelper->getMethodInstance($paymentMethod);

        if (method_exists($method, 'isRestMode') && $method->isRestMode()) {
            return false;
        }

        return true;
    }

    public function getRedirectUrl(Quote $quote, ?int $orderId = null): string
    {
        return $this->dataHelper->getCheckoutRedirectUrl();
    }
}