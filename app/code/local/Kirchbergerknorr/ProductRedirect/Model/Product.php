<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_ProductRedirect_Model_Product extends Mage_Core_Model_Abstract
{
    // Identifiers for data loading and saving
    const PRODUCT_ID = "product_id";
    const SKU = "sku";
    const PRODUCT_NAME = "product_name";
    const DESCRIPTION = "short_desc";
    const CATEGORY_IDS = "category_id_array";
    const URL = "url";


    protected function _construct()
    {
        $this->_init('productredirect/product');
    }
}