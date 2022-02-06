<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Model\DataProvider;

use Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest\CollectionFactory as RegularCustomerRequestCollectionFactory;
use Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest\Collection as RegularCustomerRequestCollection;
use Magento\Store\Model\Website;

class DiscountRequestsProvider
{
    private RegularCustomerRequestCollectionFactory $regularCustomerRequestCollectionFactory;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private RegularCustomerRequestCollection $currentCustomerDiscountRequests;

    public function __construct(
        RegularCustomerRequestCollectionFactory $regularCustomerRequestCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->regularCustomerRequestCollectionFactory = $regularCustomerRequestCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get a list of current customer regular customer requests
     *
     * @param int $customerId
     * @return RegularCustomerRequestCollection
     */
    public function getCurrentCustomerDiscountRequests(int $customerId): RegularCustomerRequestCollection
    {
        if (!isset($this->currentCustomerDiscountRequests)) {
            /** @var Website $website */
            $website = $this->storeManager->getWebsite();

            /** @var RegularCustomerRequestCollection $collection */
            $collection = $this->regularCustomerRequestCollectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId);
            // @TODO: check if accounts are shared per website or not
            $collection->addFieldToFilter('store_id', ['in' => $website->getStoreIds()]);
            $this->currentCustomerDiscountRequests = $collection;
        }

        return $this->currentCustomerDiscountRequests;
    }
}
