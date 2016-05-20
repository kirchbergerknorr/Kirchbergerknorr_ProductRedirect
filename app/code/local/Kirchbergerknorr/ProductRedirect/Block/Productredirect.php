<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_ProductRedirect_Block_Productredirect extends Mage_Core_Block_Template
{
    /**
     * after loading the redirect page, ID of deleted product is stored here
     * @var int
     */
    protected $deletedProductId;


    /**
     * @return Kirchbergerknorr_ProductRedirect_Model_Product
     */
    public function getRedirectProduct()
    {
        $redirectedProduct = Mage::getModel('productredirect/product');
        $redirectedProduct->load($this->deletedProductId, $redirectedProduct::PRODUCT_ID);
        return $redirectedProduct;
    }

    /**
     * @return string
     */
    public function getRedirectProductName()
    {
        $singleton = Mage::getSingleton('productredirect/product');
        $names = $this->getRedirectProduct()->getData($singleton::PRODUCT_NAME);
        $names = unserialize($names);

        return $names[Mage::app()->getStore()->getStoreId()];
    }

    /**
     * Get product short description
     * @return string
     */
    public function getRedirectProductDesc()
    {
        $singleton = Mage::getSingleton('productredirect/product');
        $descs = $this->getRedirectProduct()->getData($singleton::DESCRIPTION);
        $descs = unserialize($descs);

        return $descs[Mage::app()->getStore()->getStoreId()];
    }

    /**
     * @return array(int)
     */
    public function getRedirectProductCategoryIds()
    {
        $singleton = Mage::getSingleton('productredirect/product');
        $idString = $this->getRedirectProduct()->getData($singleton::CATEGORY_IDS);

        return array_map('intval', explode(',', $idString));
    }

    /**
     * @return string
     */
    public function getRedirectProductSku()
    {
        $singleton = Mage::getSingleton('productredirect/product');
        return $this->getRedirectProduct()->getData($singleton::SKU);
    }
    

    public function setDeletedProductId($id)
    {
        $this->deletedProductId = $id;
        return $this;
    }

    public function getDeletedProductId()
    {
      return $this->deletedProductId;
    }
}