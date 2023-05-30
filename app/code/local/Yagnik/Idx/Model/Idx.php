<?php

class Yagnik_Idx_Model_Idx extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('idx/idx');

    }

    public function updateTable($model, $data)
    {
        $collection =$model->getCollection();
        $collectionArray = $collection->getData();
        $BrandNames = array_column($collectionArray,'name');

        $new = [];
        foreach ($data as $key => $value) {
            $collection =$model->getCollection();
            $collection->addFieldToFilter('name', $value);
            if(!$collection->getData())
            {
                $insertId = $model->setData(['name' => $value])->save();
                $id = $insertId->getId();
                $new[$id] = $value;
            }
        }

        return $new;
    }


    public function updateTableColumn($model, $column)
    {
        $primaryKey = $column.'_id';
        $collection = $this->getCollection();
        $collectionArray = $collection->getData();

        $idxModelId = array_column($collectionArray, $primaryKey);
        $idxModelNames = array_column($collectionArray, $column);
        $idxModelNames = array_combine($idxModelId, $idxModelNames);

        $modelCollection = $model->getCollection();
        $modelCollectionArray = $model->getCollection()->getData();

        $modelBrandId = array_column($modelCollectionArray, $primaryKey);
        $modelNames = array_column($modelCollectionArray,'name');
        $modelNames = array_combine($modelBrandId,$modelNames);

        $new = $this->updateTable($model, array_unique($idxModelNames));

        foreach ($collection as $idx) {
            $idxColumnName = $idx->getData($column);
            if ($modelId = array_search($idxColumnName, $new)) {
                $resource = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName('import_product_idx');
                $condition = '`index` = '.$idx->index;
                $query = "UPDATE `{$tableName}` SET `{$primaryKey}` = {$modelId} WHERE {$condition}";
                if ($connection->query($query)) {
                    return true;
                }
            }
        }
    }

    
}