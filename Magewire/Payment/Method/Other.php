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
use \Lyranetwork\Payzen\Model\OtherConfigProvider as ConfigProvider;

class Other extends Payzen
{
    public function __construct(
        Session $checkoutSession,
        CartRepositoryInterface $cartRepository,
        ConfigProvider $configProvider
    ) {
        parent::__construct($checkoutSession, $cartRepository, $configProvider, \Lyranetwork\Payzen\Helper\Data::METHOD_OTHER);
    }
}