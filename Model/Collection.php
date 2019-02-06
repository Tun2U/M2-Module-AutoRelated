<?php
/**
 * @category    Tun2U
 * @package     Tun2U_AutoRelated
 * @author      Tun2U Team <info@tun2u.com>
 * @copyright   Copyright (c) 2019 Tun2U (https://www.tun2u.com)
 * @license     https://opensource.org/licenses/gpl-3.0.html  GNU General Public License (GPL 3.0)
 */

namespace Tun2U\AutoRelated\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\CatalogInventory\Helper\Stock;
use Magento\Catalog\Model\Product\Visibility;

class Collection extends AbstractModel
{

    /**
    * @var \Magento\Core\Model\Factory\Helper
    */
    protected $_helper;

    /**
    * @var \Magento\Framework\App\ObjectManager
    */
    //protected $_objectManager;

    /**
    * @var \Magento\Framework\Registry
    */
    protected $_registry;

    /**
    * @var Stock
    */
    protected $_stockHelper;

    /**
    * @var \Magento\Catalog\Model\Product\Visibility
    */
    protected $_productVisibility;


    public function __construct(
        Registry $registry,
        ObjectManagerInterface $helperFactory,
        Stock $stockHelper,
        Visibility $productVisibility
    ) {
        $this->_registry = $registry;
        $this->_helper = $helperFactory;
        $this->_stockHelper = $stockHelper;
        $this->_productVisibility = $productVisibility;
    }


    public function getRelatedProducts($limit = false)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $products = $this->getData('products');

        if (!$products) {
            $product = $this->_registry->registry('product');
            if ($category = $this->_registry->registry('category')) {
            } elseif ($product) {
                $ids = $product->getCategoryIds();
                if (!empty($ids)) {
                    $category = $objectManager->get('Magento\Catalog\Model\Category')->load($ids[count($ids)-1]);
                }
            }

            if ($category) {
                if ($limit === false) {
                        $limit = $this->_helper->get('Tun2U\AutoRelated\Helper\Data')->get_limit();
                }

                $products = $objectManager->get('Magento\Catalog\Model\ResourceModel\Product\Collection')
                ->setVisibility($this->_productVisibility->getVisibleInSiteIds())
                ->addAttributeToFilter('status', 1)
                //->addAttributeToFilter('qty', array('gt' => 0))
                ->addCategoryFilter($category)
                ->addAttributeToSelect('*')
                ->setPageSize($limit);

                if ($product) {
                    $products->addAttributeToFilter('entity_id', array(
                        'neq' => $this->_registry->registry('product')->getId()));
                }

                //$this->_stockHelper->addInStockFilterToCollection($products);
                $products->getSelect()->order(new \Zend_Db_Expr('RAND()'));

                $this->setData('related_products', $products);
            } else {
                return false;
            }
        }

        return $products;
    }
}
