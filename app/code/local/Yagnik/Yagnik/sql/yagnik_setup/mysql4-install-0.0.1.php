<?php 

$this->startSetup();

$this->addEntityType(Yagnik_Yagnik_Model_Resource_Yagnik::ENTITY,[
	'entity_model'=>'yagnik/yagnik',
	'attribute_model'=>'yagnik/attribute',
	'table'=>'yagnik/yagnik',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'yagnik/eav_attribute',
	'entity_attribute_collection' => 'yagnik/yagnik_attribute_collection'
]);

$this->createEntityTables('yagnik');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('yagnik', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'yagnik'");

$this->endSetup();