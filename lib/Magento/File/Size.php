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
 * @package     Framework
 * @subpackage  File
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Magento file size lib
 */
namespace Magento\File;

class Size
{
    /**
     * Maximum file size for MAX_FILE_SIZE attribute of a form
     *
     * @link http://www.php.net/manual/en/features.file-upload.post-method.php
     * @var integer
     */
    protected static $_maxFileSize = -1;

    /**
     * Get post max size
     *
     * @return string
     */
    public function getPostMaxSize()
    {
        return $this->_iniGet('post_max_size');
    }

    /**
     * Get upload max size
     *
     * @return string
     */
    public function getUploadMaxSize()
    {
        return $this->_iniGet('upload_max_filesize');
    }

    /**
     * Get max file size in megabytes
     *
     * @param int $precision
     * @param int $mode
     * @return float
     */
    public function getMaxFileSizeInMb($precision = 0, $mode = PHP_ROUND_HALF_DOWN)
    {
        return $this->getFileSizeInMb($this->getMaxFileSize(), $precision, $mode);
    }

    /**
     * Get file size in megabytes
     *
     * @param int $fileSize
     * @param int $precision
     * @param int $mode
     * @return float
     */
    public function getFileSizeInMb($fileSize, $precision = 0, $mode = PHP_ROUND_HALF_DOWN)
    {
        return round($fileSize / (1024 * 1024), $precision, $mode);
    }

    /**
     * Get the maximum file size of the a form in bytes
     *
     * @return integer
     */
    public function getMaxFileSize()
    {
        if (self::$_maxFileSize < 0) {
            $postMaxSize = $this->convertSizeToInteger($this->getPostMaxSize());
            $uploadMaxSize = $this->convertSizeToInteger($this->getUploadMaxSize());
            $min = max($postMaxSize, $uploadMaxSize);

            if ($postMaxSize > 0) {
                $min = min($min, $postMaxSize);
            }

            if ($uploadMaxSize > 0) {
                $min = min($min, $uploadMaxSize);
            }

            self::$_maxFileSize = $min;
        }

        return self::$_maxFileSize;
    }

    /**
     * Converts a ini setting to a integer value
     *
     * @param string $size
     * @return integer
     */
    public function convertSizeToInteger($size)
    {
        if (!is_numeric($size)) {
            $type = strtoupper(substr($size, -1));
            $size = (int)$size;

            switch ($type) {
                case 'K':
                    $size *= 1024;
                    break;

                case 'M':
                    $size *= 1024 * 1024;
                    break;

                case 'G':
                    $size *= 1024 * 1024 * 1024;
                    break;

                default:
                    break;
            }
        }
        return (int)$size;
    }

    /**
     * Gets the value of a configuration option
     *
     * @link http://php.net/manual/en/function.ini-get.php
     * @param string $param The configuration option name
     * @return string
     */
    protected function _iniGet($param)
    {
        return trim(ini_get($param));
    }
}
