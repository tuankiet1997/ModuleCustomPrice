<?php
namespace Magenest\CustomPrice\Plugin;

class Product
{

    /**
     * @var \Magenest\CustomPrice\Model\ResourceModel\CustomPrice\CollectionFactory
     */
    protected $collectionFactory;

    protected $customerSession;

    public function __construct(
        \Magenest\CustomPrice\Model\ResourceModel\CustomPrice\CollectionFactory $collectionFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
    }

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $productId = $subject->getData('entity_id');
        $Collection = $this->collectionFactory->create();
        $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
        foreach ($Collection->getItems() as $itemRule) {
            $startDate = $itemRule['start_date'];
            $endDate = $itemRule['end_date'];
            $today = date("Y-m-d");
            if($itemRule['entity_id'] == $productId &&
                $itemRule['customer_group_id'] == $customerGroupId &&
                strtotime($today) >= strtotime($startDate) &&
                strtotime($today) <= strtotime($endDate)
            )
            {
                $result =  number_format((float)$itemRule['value'], 2, '.', '');
            }
        }
        return $result;
    }
}
