<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Hyvä Compatibility module for PayZen. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Lyranetwork\PayzenHyva\Block\Checkout\Payment\Method;

class Sepa extends Payzen
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Lyranetwork\PayzenHyva\Helper\Data $dataHelper
     * @param string $methodCode
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Lyranetwork\PayzenHyva\Helper\Data $dataHelper,
        \Lyranetwork\Payzen\Model\SepaConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($context, $dataHelper, $configProvider, \Lyranetwork\Payzen\Helper\Data::METHOD_SEPA, $data);
    }

    // Check if the 1-click payment is active for SEPA.
    public function isOneClickActive()
    {
        return $this->getMethod()->isOneClickActive();
    }

    public function getMaskedPan()
    {
        $maskedPan = $this->configProvider->getConfig()['payment'][\Lyranetwork\Payzen\Helper\Data::METHOD_SEPA]['maskedPan'];
        $string = __('You will pay with your stored means of payment %s');

        return str_replace('%s', $maskedPan, $string);
    }

    public function getPaymentMeansUrl()
    {
        return $this->dataHelper->getPaymentMeansUrl();
    }
}