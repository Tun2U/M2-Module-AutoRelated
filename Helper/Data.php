<?php
/**
 * @category    Tun2U
 * @package     Tun2U_AutoRelated
 * @author      Tun2U Team <info@tun2u.com>
 * @copyright   Copyright (c) 2019 Tun2U (https://www.tun2u.com)
 * @license     https://opensource.org/licenses/gpl-3.0.html  GNU General Public License (GPL 3.0)
 */

namespace Tun2U\AutoRelated\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const SETTINGS_ENABLED = 'autorelated/setup/enabled';
    const SETTINGS_LIMIT = 'autorelated/setup/limit';
    const SETTINGS_CACHE_LIFETIME = 'autorelated/setup/cache_lifetime';

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;


    /**
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
    }


    public function getConfigData($field, $store = null)
    {
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            $field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        return $result;
    }


    public function get_enabled($storeId = null)
    {
        return $this->getConfigData(self::SETTINGS_ENABLED, $storeId);
    }


    public function get_limit($storeId = null)
    {
        return $this->getConfigData(self::SETTINGS_LIMIT, $storeId);
    }


    public function get_cache_lifetime($storeId = null)
    {
        return $this->getConfigData(self::SETTINGS_CACHE_LIFETIME, $storeId);
    }
}
