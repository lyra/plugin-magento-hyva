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

class Standard extends \Lyranetwork\Payzen\Block\Payment\Form\Standard
{
    /**
     * @var \Hyva\Checkout\Model\Config
     */
    protected $checkoutConfig;

    /**
     * @var \Hyva\Checkout\ViewModel\Navigation
     */
    protected $checkoutNavigation;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Lyranetwork\Payzen\Helper\Data $dataHelper
     * @param \Hyva\Checkout\Model\Config $checkoutConfig
     * @param \Hyva\Checkout\ViewModel\Navigation $checkoutNavigation
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Lyranetwork\Payzen\Helper\Data $dataHelper,
        \Hyva\Checkout\Model\Config $checkoutConfig,
        \Hyva\Checkout\ViewModel\Navigation $checkoutNavigation,
        array $data = []
    ) {
        $this->checkoutConfig = $checkoutConfig;
        $this->checkoutNavigation = $checkoutNavigation ;

        parent::__construct($context, $dataHelper, $data);
    }

    public function getMethod()
    {
        return $this->dataHelper->getMethodInstance(\Lyranetwork\Payzen\Helper\Data::METHOD_STANDARD);
    }

    public function showSmartform()
    {
        if (! $this->isRestMode()) {
            return false;
        }

        $namespace = $this->checkoutConfig->getActiveCheckoutNamespace();
        if ($namespace == 'mobile') {
            $navigator = $this->checkoutNavigation->getNavigator();

            return ($navigator->getActiveStep() == 'Summary');
        }

        return true;
    }

    public function isRestMode()
    {
        return $this->getMethod()->isRestMode();
    }

    public function getSmartformAttributes()
    {
        if ($this->getMethod()->getRestPopinMode() == 1) {
            return 'kr-popin';
        }

        $attributes = 'kr-single-payment-button';
        if ($this->getMethod()->getEntryMode() == '6') {
            $attributes .= ' kr-card-form-expanded';
        } elseif ($this->getMethod()->getEntryMode() == '7') {
            $attributes .= ' kr-card-form-expanded kr-no-card-logo-header';
        }

        return $attributes;
    }

    public function getDisplayTitle()
    {
        if ($this->getMethod()->getRestPopinMode() == 1) {
            return true;
        }

        return $this->getMethod()->getDisplayTitle();
    }
}