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

namespace Lyranetwork\PayzenHyva\Model\Plugin;

class IconRenderer
{
    public function aroundRenderAsImage(\Hyva\Checkout\Model\MethodMetaData\IconRenderer $subject, callable $proceed, string $url, array $attributes = []): string
    {
        if ($attributes && isset($attributes['payzen_other'])) {
           return '<img src ="' . $url . '">';
        }

        return $proceed($url, $attributes);
    }
}