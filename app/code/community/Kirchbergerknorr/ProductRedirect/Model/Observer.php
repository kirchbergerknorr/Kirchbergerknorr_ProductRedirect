<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Kirchbergerknorr_ProductRedirect_Model_Observer
{
    /**
     * @Event catalog_product_delete_before.
     * Saves vital product information into a custom collection and DB.
     */
    public function saveDeletedProductInfo(Varien_Event_Observer $observer)
    {
        if(Mage::getStoreConfig('product_redirect/general/active')) {
            /**
             * @var Mage_Catalog_Model_Product
             */
            $product = $observer->getEvent()->getProduct();

            try {
                Mage::getResourceModel('productredirect/product')->saveDeletedProduct($product);
            } catch(Exception $e) {
                $errorMessage = date('d.m.y  H:i', time()) . " - Error: " . $e->getMessage();
                Mage::log($errorMessage, null, 'ProductRedirect.log');;
            }
        }
    }

}