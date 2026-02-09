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

namespace Lyranetwork\PayzenHyva\ViewModel\Plugin;

use Hyva\Checkout\ViewModel\Checkout\Payment\MethodList as HyvaMethodList;
use Magento\Framework\View\Element\Template;
use Magento\Payment\Model\MethodInterface as PaymentMethodInterface;

class MethodList
{
    /**
     * @var \Lyranetwork\Payzen\Helper\Data
     */
    protected $dataHelper;

    public function __construct(
        \Lyranetwork\Payzen\Helper\Data $dataHelper
    )
    {
        $this->dataHelper = $dataHelper;
    }

    public function aroundGetMethodBlock(HyvaMethodList $subject, callable $proceed, Template $block, PaymentMethodInterface $method)
    {
        if ($method instanceof \Lyranetwork\PayzenHyva\Model\Method\Virtual) {
            $otherMethodInstance = $this->dataHelper->getMethodInstance(\Lyranetwork\Payzen\Helper\Data::METHOD_OTHER, 1);
            $methodBlock = $proceed($block, $otherMethodInstance);
            $means = substr($method->getCode(), strlen('payzen_other_'));

            return $methodBlock->setData('metadata',
                [
                    'id'=> $method->getId(),
                    'icon' => [
                        'src' => $this->dataHelper->getCcTypeImageSrc($means),
                        'attributes' => ['payzen_other' => 1]
                    ]
                ]
            );
        }

        return $proceed($block, $method);
    }
}