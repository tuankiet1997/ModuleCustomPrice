<?php
namespace Magenest\CustomPrice\Model\ResourceModel\CustomPrice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\CustomPrice\Model\CustomPrice', 'Magenest\CustomPrice\Model\ResourceModel\CustomPrice');
    }
}
