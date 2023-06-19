<?php
class Yagnik_Yagnik_Model_Resource_Yagnik_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('yagnik');
		parent::__construct();	
	}
}