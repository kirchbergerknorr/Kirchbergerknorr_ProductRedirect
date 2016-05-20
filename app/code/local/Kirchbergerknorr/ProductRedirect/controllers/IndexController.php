<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_ProductRedirect_IndexController extends Mage_Core_Controller_Front_Action
{

    //TODO: Mehrsprachige shops unterstützen
    function ProductAction()
    {
        $id = $this->getRequest()->getParam('id');


        $this->loadLayout();

        // Pass product id from url to block
        $this->getLayout()
             ->getBlock('productredirect')
             ->setDeletedProductId($id);


        $this->renderLayout();
    }
}