<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Kirchbergerknorr_ProductRedirect_Model_Resource_Product extends Mage_Core_Model_Resource_Db_Abstract
{

    protected $_defaultView;
    protected $_write;

    protected function _construct()
    {
        $this->_defaultView = Mage::app()
            ->getWebsite(true)
            ->getDefaultGroup()
            ->getDefaultStoreId();

        $this->_write = Mage::getSingleton( 'core/resource' )->getConnection( 'core_write' );

        $this->_init('productredirect/product', 'redirect_id');
    }

    /**
     * Stores some info of deleted product in table catalog_product_redirect
     * for url-redirection, avoiding 404 page
     *
     * @param $product Mage_Catalog_Model_Product
     * @throws Exception
     */
    public function saveDeletedProduct($product)
    {
        $product = Mage::getModel('catalog/product')->setStoreId($this->_defaultView)->load($product->getId());
        $categoryIds = $product->getCategoryIds();
        $urlPath = $product->getUrlPath();
        $id = $product->getId();
        $sku = $product->getSku();

        $redirectedProduct = Mage::getModel('productredirect/product');
        $catUrlProductPaths = array();

        $categoryIdsToString = '';
        foreach($categoryIds as $catId)
        {
            if($catId > 2)
            {
                // save all category ids as one string("category1,category2,...")
                $categoryIdsToString .= $catId;
                if ($catId !== end(array_values($categoryIds)))
                {
                    $categoryIdsToString .= ',';
                }

                // Save all category url paths for each store view
                foreach (Mage::app()->getStores() as $store)
                {
                    $env = Mage::getSingleton('core/app_emulation')->startEnvironmentEmulation($store);
                    $catUrlProductPaths[] = str_replace(".html", "/", Mage::getModel('catalog/category')->load($catId)->getUrlPath()) . $urlPath;
                    Mage::getSingleton('core/app_emulation')->stopEnvironmentEmulation($env);
                }
            }
        }
        // Remove duplicate entries
        $catUrlProductPaths = array_unique($catUrlProductPaths);

        // save names from all store views
        $names = Mage::helper('productredirect/data')->getProductFieldsFromAllStoreViews($product, 'name');

        // save short descriptions from all store views
        $descs = Mage::helper('productredirect/data')->getProductFieldsFromAllStoreViews($product, 'short_description');

        // Save deleted product in table
        $redirectedProduct->setData(array
        (
            $redirectedProduct::DESCRIPTION => $descs,
            $redirectedProduct::PRODUCT_ID => $id,
            $redirectedProduct::PRODUCT_NAME => $names,
            $redirectedProduct::SKU => $sku,
            $redirectedProduct::URL => $urlPath,
            $redirectedProduct::CATEGORY_IDS => $categoryIdsToString
        ));
        $redirectedProduct->save();

        // Redirect product urls to redirection page
        if(!empty($urlPath))
        {
            $rewrite = Mage::getModel('core/url_rewrite')
                ->setStoreId($this->_defaultView)
                ->loadByRequestPath($urlPath);

            // If rewrite exists, update all url rewrites and set new target path
            if($rewrite->getId()) {
                $query = "UPDATE core_url_rewrite SET target_path = :target_path WHERE request_path = :request_path";
                $binds = array(
                    'target_path' => 'productredirect/index/product/id/' . $id,
                    'request_path' => $urlPath
                );

                $this->_write->query( $query, $binds );
            } else {
                $rewrite = Mage::getModel('core/url_rewrite');
                $rewrite->setOptions('RP')
                    ->setIdPath('productredirect/' . $id)
                    ->setTargetPath('productredirect/index/product/id/' . $id)
                    ->setRequestPath($urlPath)
                    ->setData('is_deleted', 1);
                $rewrite->save();
            }
        }

        foreach($catUrlProductPaths as $catUrl)
        {
            if(!empty($catUrl))
            {
                $rewriteCat = Mage::getModel('core/url_rewrite')
                    ->setStoreId($this->_defaultView)
                    ->loadByRequestPath($catUrl);

                if($rewriteCat->getId()) {
                    $query = "UPDATE core_url_rewrite SET target_path = :target_path WHERE request_path = :request_path";
                    $binds = array(
                        'target_path' => 'productredirect/index/product/id/' . $id,
                        'request_path' => $catUrl
                    );

                    $this->_write->query( $query, $binds );
                } else {
                    $rewriteCat = Mage::getModel('core/url_rewrite');
                    $rewriteCat->setOptions('RP')
                        ->setRequestPath($catUrl)
                        ->setIdPath('productredirect/' . $catUrl)
                        ->setTargetPath('productredirect/index/product/id/' . $id)
                        ->setData('is_deleted', 1);

                    $rewriteCat->save();
                }
            }
        }
    }

}