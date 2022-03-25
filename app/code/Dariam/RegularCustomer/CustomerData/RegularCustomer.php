<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\CustomerData;

use Dariam\RegularCustomer\Model\DataProvider\RegularCustomersProvider;

class RegularCustomer implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    private RegularCustomersProvider $regularCustomerProvider;

    private \Magento\Customer\Model\Session $customerSession;

    /**
     * RegularCustomer constructor.
     * @param RegularCustomersProvider $regularCustomerProvider
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        RegularCustomersProvider $regularCustomerProvider,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->regularCustomerProvider = $regularCustomerProvider;
        $this->customerSession = $customerSession;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        $name = (string) $this->customerSession->getRegularCustomerName();
        $email = (string) $this->customerSession->getRegularCustomerEmail();

        if ($this->customerSession->isLoggedIn()) {
            if (!$name) {
                $name = $this->customerSession->getCustomer()->getName();
            }

            if (!$email) {
                $email = $this->customerSession->getCustomer()->getEmail();
            }

            $customerId = $this->customerSession->getCustomerId();

            $discountRequestCollection = $this->regularCustomerProvider->getCustomerDiscountRequests((int) $customerId);

            $productIds = $discountRequestCollection->getColumnValues('product_id');
            $productIds = array_map('intval', array_unique($productIds));
        } else {
            $productIds = $this->customerSession->getRegularCustomerProductIds() ?: [];
        }

        return [
            'name' => $name,
            'email' => $email,
            'productIds' => $productIds,
            'isLoggedIn' => $this->customerSession->isLoggedIn(),
        ];
    }
}
