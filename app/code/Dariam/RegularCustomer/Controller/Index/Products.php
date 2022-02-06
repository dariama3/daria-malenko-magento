<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Controller\Index;

use Dariam\RegularCustomer\Model\DataProvider\DiscountRequestsProvider;
use Magento\Framework\Controller\Result\Json;

class Products implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    private \Magento\Customer\Model\Session $customerSession;

    private DiscountRequestsProvider $discountRequestsProvider;

    private \Psr\Log\LoggerInterface $logger;

    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Customer\Model\Session $customerSession,
        DiscountRequestsProvider $discountRequestsProvider,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->discountRequestsProvider = $discountRequestsProvider;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
    }

    /**
     * @inerhitDoc
     */
    public function execute(): Json
    {
        $products = [];

        try {
            if ($this->customerSession->isLoggedIn()) {
                $customerId = $this->customerSession->getCustomerId();

                $currentCustomerDiscountRequests = $this->discountRequestsProvider->getCurrentCustomerDiscountRequests($customerId);

                $products = $currentCustomerDiscountRequests->getColumnValues('product_id');
            } else {
                $products = $this->customerSession->getRegularCustomerProductIds() ?: [];
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $this->jsonFactory->create()
            ->setData([
                'products' => $products
            ]);
    }
}
