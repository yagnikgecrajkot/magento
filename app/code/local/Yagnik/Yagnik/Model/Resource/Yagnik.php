<?php 
class Yagnik_Yagnik_Model_Resource_Yagnik extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'yagnik';
	public function __construct()
	{
		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');
	   parent::__construct();
    }
}