<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_ProductRedirect
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_ProductRedirect_IndexController extends Mage_Core_Controller_Front_Action
{
    public function productAction()
    {
        $id = $this->getRequest()->getParam('id');

        if($code = $this->getHttpStatusCode()) {
            $this->getResponse()->setHeader('HTTP/1.1', $code);
            $this->getResponse()->setHeader('Status', $code);
        }

        $this->loadLayout();

        // Pass product id from url to block
        $this->getLayout()
             ->getBlock('productredirect')
             ->setDeletedProductId($id);


        $this->renderLayout();
    }

    protected function getHttpStatusCode()
    {
        $codes = [
            301 => ['status' => "301 Moved Permanently"],
            302 => ['status' => "302 Found"],
            404 => ['status' => "404 Not Found"],
            410 => ['status' => "410 Gone"],
        ];
        if($code = Mage::getStoreConfig('product_redirect/general/status_codes')) {
            if(isset($codes[$code])) {
                return $codes[$code]['status'];
            }
        }

        return null;
    }
}