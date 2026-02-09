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

class Multi extends Payzen
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Lyranetwork\PayzenHyva\Helper\Data $dataHelper
     * @param string $methodCode
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Lyranetwork\PayzenHyva\Helper\Data $dataHelper,
        \Lyranetwork\Payzen\Model\MultiConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($context, $dataHelper, $configProvider, \Lyranetwork\Payzen\Helper\Data::METHOD_MULTI, $data);
    }

    public function isLocalCcType()
    {
        return $this->getMethod()->isLocalCcType();
    }

    public function getAvailableCcTypes()
    {
        return $this->getMethod()->getAvailableCcTypes();
    }

    public function getAvailableOptions()
    {
        $quote = $this->dataHelper->getCheckoutQuote();
        $amount = ($quote && $quote->getId()) ? $quote->getBaseGrandTotal() : null;

        return $this->getMethod()->getAvailableOptions($amount);
    }
}