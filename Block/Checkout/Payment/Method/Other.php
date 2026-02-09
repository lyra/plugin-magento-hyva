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

class Other extends Payzen
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
        \Lyranetwork\Payzen\Model\OtherConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($context, $dataHelper, $configProvider, \Lyranetwork\Payzen\Helper\Data::METHOD_OTHER, $data);
    }

    public function regroupPaymentMeans()
    {
        return $this->getMethod()->getConfigData('regroup_payment_means');
    }

    public function getAvailableMeans()
    {
        return $this->getMethod()->getAvailableMeans($this->dataHelper->getCheckoutQuote());
    }
}