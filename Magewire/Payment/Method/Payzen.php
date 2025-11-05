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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magewirephp\Magewire\Component;
use \Lyranetwork\Payzen\Model\PayzenConfigProvider as ConfigProvider;

class Payzen extends Component
{
    protected Session $checkoutSession;
    protected ConfigProvider $configProvider;
    protected CartRepositoryInterface $cartRepository;

    protected ?array $loadedConfig;
    protected string $methodCode;

    public array $paymentData = [];

    public function __construct(
        Session $checkoutSession,
        CartRepositoryInterface $cartRepository,
        ConfigProvider $configProvider,
        string $methodCode
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
        $this->configProvider = $configProvider;
        $this->methodCode = $methodCode;
    }

    public function getPaymentData(string $method): array
    {
        $this->paymentData = $this->getConfig();

        return $this->paymentData;
    }

    protected function getConfig(): array
    {
        $this->loadedConfig = $this->configProvider->getConfig()['payment'][$this->methodCode];

        return $this->loadedConfig;
    }
}