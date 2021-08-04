<?php
namespace Magenest\CustomPrice\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class CustomPrice extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magenest\CustomPrice\Model\ResourceModel\CustomPrice');
    }
}
