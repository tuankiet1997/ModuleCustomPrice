<?php

namespace Magenest\CustomPrice\Controller\Adminhtml\CustomPrice;

use Magento\Framework\Message\Manager;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\CustomPrice\Model\CustomPriceFactory;

class AddPost extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var Manager
     */
    protected $messageManager;

    /**
     * 20210414 - WIKI Kiet Ngo
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    protected $_customPriceFactory;

    protected $_productRepository;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param CustomPriceFactory $customPriceFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param Manager $messageManager
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        CustomPriceFactory $customPriceFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        Manager $messageManager,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_productRepository = $productRepository;
        $this->_customPriceFactory = $customPriceFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $requestData = $this->request->getParams();
            $id = !empty($requestData['customprice']['id']) ? $requestData['customprice']['id'] : null;
            $productId = $this->_productRepository->get($requestData['customprice']['product_sku'])->getId();
            $dataCustomPrice = [
               'entity_id' => $productId,
                'customer_group_id' => $requestData['customprice']['customer_group_id'][0],
                'start_date' => $requestData['customprice']['start_date'],
                'end_date' => $requestData['customprice']['end_date'],
                'value' => $requestData['customprice']['price_value']
            ];
            $data = $this->_customPriceFactory->create();
            if($id){
                $data->load($id);
                $data->addData($dataCustomPrice);
                $data->setId($id);
                $data->save();
            }else{
                $data->setData($dataCustomPrice)->save();
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
    }
}
