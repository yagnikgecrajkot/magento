<?php

class Yagnik_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    
    function indexAction()
    {
        $this->_title($this->__('Idx'))
             ->_title($this->__('Manage Idxs'));
        $this->loadLayout();
        $this->_setActiveMenu('idx/manage');
        $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__('Attributes'))
             ->_title($this->__('import Options'));
            $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('idx/adminhtml_idx_edit_tabs'));

        $this->renderLayout();
    }



    public function massDeleteAction()
    {
        try {
            $idxId = $this->getRequest()->getParam('index');
            if(!is_array($idxId)) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('idx/idx')->__('Please select tax(es).'));
            } else {
                $model = Mage::getModel('idx/idx');
                foreach ($idxId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('idx/idx')->__('Total of %d record(s) were deleted.', count($idxId))
                );
            }
             
            $this->_redirect('*/*/index');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());            
        }
    }

    public function importAction()
    {
        try {
            Mage::getModel('idx/idx')->truncate();
            if ($_FILES['import_options']['error'] == UPLOAD_ERR_OK) {
                $csvFile = $_FILES['import_options']['tmp_name'];
                $csvData = file_get_contents($csvFile);
                $csvData = array();

                if (($handle = fopen($csvFile, 'r')) !== false) {
                    // Read each line of the file
                    while (($data = fgetcsv($handle)) !== false) {
                        // Convert the line into an array
                        $row = array();
                        foreach ($data as $value) {
                            $row[] = $value;
                        }
                        // Add the row to the CSV data array
                        $csvData[] = $row;
                    }
                      fclose($handle);
                }


                $header = [];
                foreach ($csvData as $value)
                {
                    if(!$header)
                    {
                        $header = $value;
                    }
                    else
                    {
                        $data = array_combine($header,$value);

                        $collection = Mage::getResourceModel('idx/idx_collection');

                        $attribute = $collection->getData();

                        $model = Mage::getModel('idx/idx');
                        $model->setData($data)->save();
                        // print_r($attribute);
                    }
                }
            }
        } catch (Exception $e) {
            
        }

        Mage::getSingleton('core/session')->addSuccess($this->__('Option inserted successfully'));

        $this->_redirect('*/*/index');
    }

    public function brandAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');       
            $idxCollection = $idx->getCollection();
            $idxCollectionArray = $idx->getCollection()->getData();
            $idxBrandId = array_column($idxCollectionArray,'index');
            $idxBrandNames = array_column($idxCollectionArray,'brand');
            $idxBrandNames = array_combine($idxBrandId,$idxBrandNames);

            $newBrands = $idx->updateBrandTable(array_unique($idxBrandNames));

            $idxCollection = $idx->getCollection();
            foreach ($idxCollection as $idx) {
                if(!$idx->brand_id)
                {
                    $brand = Mage::getModel('brand/brand');
                    $brandCollection = Mage::getModel('brand/brand')->getCollection();
                    $brandCollection->getSelect()->where('main_table.name=?',$idx->brand);
                    $brandData = $brandCollection->getData();
                    $resource = Mage::getSingleton('core/resource');
                    $connection = $resource->getConnection('core_write');
                    $tableName = $resource->getTableName('import_product_idx');
                    $condition = '`index` = '.$idx->index;
                    $query = "UPDATE `{$tableName}` SET `brand_id` = {$brandData[0]['brand_id']} WHERE {$condition}";
                    $connection->query($query); 
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is fine now');

        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }

    public function collectionAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');  
            $idxCollection = $idx->getCollection();     
            $idxCollectionData = $idx->getCollection()->getData();

            $idxBrandNames = array_column($idxCollectionData,'collection');
            $newBrands = $idx->updateCollectionOption(array_unique($idxBrandNames));

            $resource = Mage::getSingleton('core/resource');
            $writeAdapter = $resource->getConnection('core_write');

            $productIdxTable = $resource->getTableName('idx/idx');
            $optionValueTable = $resource->getTableName('eav_attribute_option_value');

            $updateQuery = "
                UPDATE {$productIdxTable} p
                JOIN (
                    SELECT option_id,value
                    FROM {$optionValueTable}
                ) o ON p.`collection` = o.`value`
                SET p.`collection_id` = o.`option_id`
            ";

            $writeAdapter->query($updateQuery);
    
            Mage::getSingleton('adminhtml/session')->addSuccess('Collection is fine now');
        } catch (Exception $e) {
             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');            
    }

    public function productAction()
    {
        try {
            $idxTable = Mage::getSingleton('core/resource')->getTableName('import_product_idx');

            $idxCollection = Mage::getModel('idx/idx')->getCollection();

            foreach ($idxCollection as $idxRow) {
                if (!$idxRow->brand_id) {
                    throw new Exception("Brand is not fine", 1);
                }
                
                if (!$idxRow->collection_id) {
                    throw new Exception("Collection is not fine", 1);
                }
            }

            $productTable = Mage::getSingleton('core/resource')->getTableName('catalog_product_entity'); 

            foreach ($idxCollection as $idxRow) {
                $sku = $idxRow->sku;
                $productId = Mage::getResourceModel('catalog/product')->getIdBySku($sku);
                if ($productId) {

                    $resource = Mage::getSingleton('core/resource');
                    $writeAdapter = $resource->getConnection('core_write');
                    $tableName = $resource->getTableName('idx/idx');

                    $query = "UPDATE `{$tableName}` SET `product_id` = '{$productId}' WHERE `sku` = '{$sku}'";

                }
            }

            // Step 3: Create missing products in the product table
            $missingProducts = $idxCollection->addFieldToFilter('product_id', 0);

            foreach ($missingProducts as $missingProduct) {
                $productData = [
                    'entity_type_id' => 4,
                    'attribute_set_id' => 4,
                    'type_id' => 'simple',
                    'sku' => $missingProduct->sku,
                    'has_options' => 0,
                    'required_options' => 0,
                    'name' => $missingProduct->name,
                    'price' => $missingProduct->price,
                    'status' => $missingProduct->status,
                    'visibility' => '4',
                    'tax_class_id' => '2',
                    'weight' => '0.5',
                    'created_at' => now(),
                ];
                $storeId = Mage_Core_Model_App::ADMIN_STORE_ID;
                $product = Mage::getModel('catalog/product');
                $product->setStoreId($storeId)
                        ->setData($productData)
                        ->setStockData(array(
                            'is_in_stock' => 1,
                            'qty' => $missingProduct->quantity,
                        ))
                        ->save();

                $resource = Mage::getSingleton('core/resource');
                $writeAdapter = $resource->getConnection('core_write');

                $tableName = $resource->getTableName('idx/idx');

                $query = "UPDATE `{$tableName}` SET `product_id` = '{$product->entity_id}' WHERE `sku` = '{$product->sku}'";

                $writeAdapter->query($query);


            }

            // Step 4: Check if all rows have Product Ids
            $missingProductIds = $idxCollection;

            if ($missingProductIds->getData()) {
                Mage::getSingleton('adminhtml/session')->addError('There are products without Product Ids');
            }

            // Step 5: Display success message or prompt for further updates
            else {
                Mage::getSingleton('adminhtml/session')->addSuccess('Products are successfully imported');
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        // Redirect to the desired page
        $this->_redirect('*/*/index');
    }
}