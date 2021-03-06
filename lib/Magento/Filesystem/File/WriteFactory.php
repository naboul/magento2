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
 * @package     Magento
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Filesystem\File;

use Magento\Filesystem\DriverInterface;

class WriteFactory
{
    /**
     * @var \Magento\Filesystem\DriverFactory
     */
    protected $driverFactory;

    /**
     * @param \Magento\Filesystem\DriverFactory $driverFactory
     */
    public function __construct(\Magento\Filesystem\DriverFactory $driverFactory)
    {
        $this->driverFactory = $driverFactory;
    }

    /**
     * Create a readable file.
     *
     * @param string $path
     * @param string|null $protocol
     * @param DriverInterface $directoryDriver [optional]
     * @param string $mode
     * @return Write
     */
    public function create($path, $protocol, DriverInterface $directoryDriver = null, $mode = 'r')
    {
        $fileDriver = $directoryDriver;
        if ($protocol) {
            $fileDriver = $this->driverFactory->get($protocol, $directoryDriver);
        }
        return new \Magento\Filesystem\File\Write($path, $fileDriver, $mode);
    }
}
