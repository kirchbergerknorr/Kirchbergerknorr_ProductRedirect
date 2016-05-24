<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Kirchbergerknorr_ProductRedirect_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Check whether at least one of the given category ids exists
     * @param $categoryIds array(int)
     * @return boolean
    */
    public function DoCategoriesExist($categoryIds)
    {
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToFilter('entity_id', $categoryIds);

        return $categories->getSize() > 0;
    }

    /**
     * Gets category name by ID
     * @param $categoryId int
     * @return string
     */
    public function getCategoryName($categoryId)
    {
        $category = Mage::getSingleton('catalog/category')->load($categoryId);

        if(is_object($category) && $category->getId())
        {
            return $category->getName();
        }
        else
            return "";
    }

    /**
     * Gets category url path by ID
     * @param $categoryId int
     * @return string
     */
    public function getCategoryUrl($categoryId)
    {
        $category = Mage::getSingleton('catalog/category')->load($categoryId);

        if(is_object($category) && $category->getId())
        {
            return Mage::getBaseUrl() . $category->getUrlPath();
        }
        else
            return "";
    }

    /**
     * Returns an array serialized as string of given attribute
     * from all store views (array[storeId] => attribute).
     * @param $product Mage_Catalog_Model_Product
     * @param $attributeName string
     * @return string
     */
    public function getProductFieldsFromAllStoreViews($product, $attributeName)
    {
        $names = array();

        foreach(Mage::app()->getStores() as $store)
        {
            $attribute = Mage::getResourceModel('catalog/product')->getAttributeRawValue($product->getId(), $attributeName, $store->getId());
            $names[$store->getId()] = $attribute;
        }

        return serialize($names);
    }
}