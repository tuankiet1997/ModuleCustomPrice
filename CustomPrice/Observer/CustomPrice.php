<?php
namespace Magenest\CustomPrice\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class CustomPrice implements ObserverInterface
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

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $Collection = $this->collectionFactory->create();
        $item = $observer->getEvent()->getData('quote_item');
        $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
        foreach ($Collection->getItems() as $itemRule) {
            $startDate = $itemRule['start_date'];
            $endDate = $itemRule['end_date'];
            $today = date("Y-m-d");
            if($itemRule['entity_id'] == $item->getData('product_id') &&
                $itemRule['customer_group_id'] == $customerGroupId &&
                strtotime($today) >= strtotime($startDate) &&
                strtotime($today) <= strtotime($endDate)
            )
            {
                $item = ($item->getParentItem() ? $item->getParentItem() : $item);
                $price = number_format((float)$itemRule['value'], 2, '.', '');
                $item->setCustomPrice($price);
                $item->setOriginalCustomPrice($price);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }
}
