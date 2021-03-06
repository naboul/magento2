<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_Backend
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Config Directory currency backend model
 * Allows dispatching before and after events for each controller action
 */
namespace Magento\Backend\Model\Config\Backend\Currency;

class DefaultCurrency extends AbstractCurrency
{
    /**
     * Check default currency is available in installed currencies
     * Check default currency is available in allowed currencies
     *
     * @return $this
     * @throws \Magento\Model\Exception
     */
    protected function _afterSave()
    {
        if (!in_array($this->getValue(), $this->_getInstalledCurrencies())) {
            throw new \Magento\Model\Exception(
                __('Sorry, we haven\'t installed the default display currency you selected.')
            );
        }

        if (!in_array($this->getValue(), $this->_getAllowedCurrencies())) {
            throw new \Magento\Model\Exception(
                __('Sorry, the default display currency you selected in not available in allowed currencies.')
            );
        }

        return $this;
    }
}
