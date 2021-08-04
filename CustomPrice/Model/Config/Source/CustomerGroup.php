<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\CustomPrice\Model\Config\Source;

/**
 * Back orders source class
 */
class CustomerGroup implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * Customer Group
     *
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    protected $_customerGroup;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup
    )
    {
        $this->_customerGroup = $customerGroup;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $customerGroups = $this->_customerGroup->toOptionArray();
        return $customerGroups;

    }
}
