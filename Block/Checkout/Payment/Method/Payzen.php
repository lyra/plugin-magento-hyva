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

abstract class Payzen extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Lyranetwork\PayzenHyva\Helper\Data
     */
    protected $dataHelper;

    protected $methodCode;
    protected $method;
    protected $configProvider;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Lyranetwork\PayzenHyva\Helper\Data $dataHelper
     * @param string $methodCode
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Lyranetwork\PayzenHyva\Helper\Data $dataHelper,
        \Lyranetwork\Payzen\Model\PayzenConfigProvider $configProvider,
        $methodCode,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->dataHelper = $dataHelper;
        $this->methodCode = $methodCode;
        $this->method = $this->dataHelper->getMethodInstance($methodCode);
        $this->configProvider = $configProvider;
    }

    public function getMethod()
    {
        return $this->method;
    }

    protected function getConfig(): array
    {
        return $this->configProvider->getConfig()['payment'][$this->methodCode];
    }

    public function getCcTypeImageSrc($card)
    {
        return $this->dataHelper->getCcTypeImageSrc($card);
    }

    public function getCurrentCustomer()
    {
        return $this->getMethod()->getCurrentCustomer();
    }
}