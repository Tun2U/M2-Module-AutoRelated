<?php

/**
 * @category    Tun2U
 * @package     Tun2U_AutoRelated
 * @author      Tun2U Team <info@tun2u.com>
 * @copyright   Copyright (c) 2019 Tun2U (https://www.tun2u.com)
 * @license     https://opensource.org/licenses/gpl-3.0.html  GNU General Public License (GPL 3.0)
 */

namespace Tun2U\AutoRelated\Block\Product\ProductList;

use Magento\Framework\ObjectManagerInterface;
use Tun2U\AutoRelated\Model\Collection;

class Related extends \Magento\Catalog\Block\Product\ProductList\Related
{

	/**
	 * @var \Magento\Core\Model\Factory\Helper
	 */
	protected $_helper;


	/**
	 * @var \Magento\Store\Model\StoreManagerInterface
	 */
	protected $_storeManager;


	/**
	 * @var \Magento\Framework\Registry
	 */
	protected $_registry;


	/**
	 * @var \Tun2U\AutoRelated\Model\Collection
	 */
	protected $_collection;


	public function __construct(
		\Magento\Catalog\Block\Product\Context $context,
		\Magento\Checkout\Model\ResourceModel\Cart $checkoutCart,
		\Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Framework\Module\Manager $moduleManager,
		ObjectManagerInterface $helperFactory,
		Collection $collection,
		array $data = []
	) {
		$this->_helper = $helperFactory;
		$this->_registry = $context->getRegistry();
		$this->_storeManager = $context->getStoreManager();;
		$this->_collection = $collection;
		parent::__construct(
			$context,
			$checkoutCart,
			$catalogProductVisibility,
			$checkoutSession,
			$moduleManager,
			$data
		);

		// Only cache if we have something thats keyable..
		$_time = $this->_helper->get('Tun2U\AutoRelated\Helper\Data')->get_cache_lifetime();

		if ($_time > 0 && $cacheKey = $this->_cacheKey()) {
			$this->addData(array(
				'cache_lifetime'    => $_time,
				'cache_tags'        => array(\Magento\Store\Model\Store::CACHE_TAG),
				'cache_key'         => $cacheKey,
			));
		}
	}

	protected function _cacheKey()
	{
		$product = $this->_registry->registry('product');

		if ($product) {
			return get_class() . '::' .  $this->_storeManager->getStore()->getCode() . '::' . $product->getId();
		}

		return false;
	}

	protected function _prepareData()
	{
		parent::_prepareData();

		$_enabled = $this->_helper->get('Tun2U\AutoRelated\Helper\Data')->get_enabled();

		if ($_enabled && count($this->getItems()) == 0) {
			$_products = $this->_collection->getRelatedProducts();
			if ($_products) {
				$this->_itemCollection = $_products;
			}
		}

		return $this;
	}

	public function getIdentities()
	{
		$identities = [];
		//Bugfix: Warning: Invalid argument supplied for foreach()
		if (is_array($this->getItems()) || is_object($this->getItems())) {
			foreach ($this->getItems() as $item) {
				$identities = array_merge($identities, $item->getIdentities());
			}
		}
		return $identities;
	}
}