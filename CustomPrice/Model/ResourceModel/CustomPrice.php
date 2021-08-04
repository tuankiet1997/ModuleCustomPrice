<?php
namespace Magenest\CustomPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class CustomPrice extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('custom_price', 'id');
    }
}
