<?php
/**
 * Custom Attribute config resource - returns HTTP Statuscodes
 *
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_ProductRedirect
 * @author      Benedikt Volkmer <bv@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2016 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_ProductRedirect_Model_Resource_StatusCodes
{
    public function toOptionArray()
    {
        $codes = array(
            array('value' => '301', 'label' => '301 - Found (Moved Permanently)'),
            array('value' => '302', 'label' => '302 - Found (Moved Temporarily)'),
            array('value' => '404', 'label' => '404 - Not Found'),
            array('value' => '410', 'label' => '410 - Gone')
        );

        return $codes;
    }

}