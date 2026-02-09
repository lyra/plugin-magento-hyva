<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Hyvä Compatibility module for PayZen. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Lyranetwork\PayzenHyva\Helper;

use Composer\InstalledVersions;
use Lyranetwork\Payzen\Model\Api\Form\Api as PayzenApi;

class Data extends \Lyranetwork\Payzen\Helper\Data
{
    public function getContribParam()
    {
        $contrib = parent::getContribParam();

        if ($this->checkoutSession->getHyvaCheckout()) {
            $cmsParam = 'Magento_Hyva_2.x_1.1.0_'
                . $this->getCommonConfigData('plugin_version');
            $cmsVersion = $this->productMetadata->getVersion();
            $hyvaCheckoutVersion = InstalledVersions::getVersion('hyva-themes/magento2-hyva-checkout');

            $contrib = $cmsParam . '/' .  $hyvaCheckoutVersion . '/ '. $cmsVersion
                . '/' . PayzenApi::shortPhpVersion();
        }

        return $contrib;
    }

    /**
     * Return checkout redirect URL.
     *
     * @return string
     */
    public function getCheckoutRedirectUrl()
    {
        return $this->_getUrl('payzen/payment/redirect', ['_secure' => true]);
    }

    public function getPaymentMeansUrl()
    {
        return $this->_getUrl('vault/cards/listaction', ['_secure' => true]);
    }
}