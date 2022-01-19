<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Controller\Index;

use Dariam\RegularCustomer\Model\RegularCustomerRequest;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;

class Request implements
    \Magento\Framework\App\Action\HttpPostActionInterface,
    \Magento\Framework\App\CsrfAwareActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    /**
     * @var \Dariam\RegularCustomer\Model\RegularCustomerRequestFactory $regularCustomerRequestFactory
     */
    private \Dariam\RegularCustomer\Model\RegularCustomerRequestFactory $regularCustomerRequestFactory;

    /**
     * @var \Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest $regularCustomerRequestResource
     */
    private \Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest $regularCustomerRequestResource;

    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private \Magento\Framework\App\RequestInterface $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private \Psr\Log\LoggerInterface $logger;

    /**
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Dariam\RegularCustomer\Model\RegularCustomerRequestFactory $regularCustomerRequestFactory
     * @param \Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest $regularCustomerRequestResource
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Dariam\RegularCustomer\Model\RegularCustomerRequestFactory $regularCustomerRequestFactory,
        \Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest $regularCustomerRequestResource,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->regularCustomerRequestFactory = $regularCustomerRequestFactory;
        $this->regularCustomerRequestResource = $regularCustomerRequestResource;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->logger = $logger;
    }

    /**
     * Controller action
     *
     * @return Json
     */
    public function execute(): Json
    {
        /** @var RegularCustomerRequest $regularCustomerRequest */
        $regularCustomerRequest = $this->regularCustomerRequestFactory->create();

        try {
            $regularCustomerRequest->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setStoreId($this->storeManager->getStore()->getId());

            if ($this->request->getParam('product_id')) {
                $regularCustomerRequest->setProductId((int) $this->request->getParam('product_id'));
            }

            $this->regularCustomerRequestResource->save($regularCustomerRequest);
            $message = __('You request is accepted for review!');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __("Your request can't be sent. Please, contact us if you see this message.");
        }

        return $this->jsonFactory->create()
            ->setData([
                'message' => $message
            ]);
    }

    /**
     * Create exception in case CSRF validation failed. Return null if default exception will suffice.
     *
     * @param RequestInterface $request
     * @return InvalidRequestException|null
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * Perform custom request validation. Return null if default validation is needed.
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function validateForCsrf(RequestInterface $request): bool
    {
        return $this->formKeyValidator->validate($request);
    }
}
