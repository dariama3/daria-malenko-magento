<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\ViewModel\Customer;

use Dariam\RegularCustomer\Model\DataProvider\RegularCustomersProvider;
use Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest\Collection as RegularCustomerRequestCollection;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\Product;

class RequestList implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    private \Magento\Catalog\Model\Product\Visibility $productVisibility;

    private \Magento\Customer\Model\Session $customerSession;

    private RegularCustomersProvider $discountRequestsProvider;

    private RegularCustomerRequestCollection $loadedRegularCustomerRequestCollection;

    private ProductCollection $loadedProductCollection;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Customer\Model\Session $customerSession,
        RegularCustomersProvider $discountRequestsProvider
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productVisibility = $productVisibility;
        $this->customerSession = $customerSession;
        $this->discountRequestsProvider = $discountRequestsProvider;
    }

    /**
     * Get a list of regular customer requests
     *
     * @return RegularCustomerRequestCollection
     */
    public function getRegularCustomerRequestCollection(): RegularCustomerRequestCollection
    {
        if (!isset($this->loadedRegularCustomerRequestCollection)) {
            $customerId = $this->customerSession->getCustomerId();

            $this->loadedRegularCustomerRequestCollection = $this->discountRequestsProvider->getCustomerDiscountRequests((int)$customerId);
        }

        return $this->loadedRegularCustomerRequestCollection;
    }

    /**
     * Get product for customer discount request
     *
     * @param int $productId
     * @return Product|null
     */
    public function getProduct(int $productId): ?Product
    {
        if (isset($this->loadedProductCollection)) {
            return $this->loadedProductCollection->getItemById($productId);
        }

        $regularCustomerRequestCollection = $this->getRegularCustomerRequestCollection();
        $productIds = array_unique(array_filter($regularCustomerRequestCollection->getColumnValues('product_id')));

        $productCollection = $this->productCollectionFactory->create();
        // Inactive products are filtered by default
        $productCollection->addAttributeToFilter('entity_id', ['in' => $productIds])
            ->addAttributeToSelect('name')
            ->addWebsiteFilter()
            ->setVisibility($this->productVisibility->getVisibleInSiteIds());
        $this->loadedProductCollection = $productCollection;

        return $this->loadedProductCollection->getItemById($productId);
    }
}
