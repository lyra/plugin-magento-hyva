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

namespace Lyranetwork\PayzenHyva\Api\Plugin;

use Exception;

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

    public function aroundGetList(\Magento\Quote\Api\PaymentMethodManagementInterface $subject, callable $proceed, String $quoteId): ?array
    {
        try {
            $list = $proceed($quoteId);

            $otherMethodInstance = $this->dataHelper->getMethodInstance(\Lyranetwork\Payzen\Helper\Data::METHOD_OTHER, 1);
            if (! $otherMethodInstance->isAvailable($this->dataHelper->getCheckoutQuote()) || $otherMethodInstance->getRegroupMode()) {
                return $list;
            }

            foreach ($list as $key => $method) {
                if ($method instanceof \Lyranetwork\Payzen\Model\Method\Other) {
                    unset($list[$key]);

                    break;
                }
            }

            // Add other payment virtual methods to the list.
            foreach ($otherMethodInstance->getAvailableMeans() as $key => $option) {
                $methodInstance = new \Lyranetwork\PayzenHyva\Model\Method\Virtual('payzen_other_' . $option['means'], $option['label'], $key);

                $list[] = $methodInstance;
            }

            return $list;
        } catch (Exception $exception) {
            return null;
        }
    }
}