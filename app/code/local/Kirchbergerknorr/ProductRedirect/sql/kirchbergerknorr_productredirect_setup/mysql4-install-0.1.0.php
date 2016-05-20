<?php
/**
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Default
 * @author      Oliver Sokola <oliver.sokola@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2015 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * Create new sql table which holds the most vital information
 * about deleted products.
 */


/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

/**
 * add is_deleted column to core_url_rewrite table
 */
$installer->getConnection()
          ->addColumn($installer->getTable('core/url_rewrite'),
                      'is_deleted',
                      array
                      (
                          'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
                          'nullable' => false,
                          'default' => 0,
                          'comment' => 'product no longer in catalog_product DB'
                      ));

/**
 * create table holding deleted products
 */
$installer->run
("
CREATE TABLE IF NOT EXISTS {$installer->getTable('catalog_product_redirect')}
(
  `redirect_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `product_name` varchar(2040) NOT NULL,
  `short_desc` varchar(2040) NOT NULL,
  `category_id_array` varchar(255) NULL,
  `url` varchar(255) NULL,
  PRIMARY KEY (`redirect_id`),
  UNIQUE (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();