<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Model;

class CurrentProductIdUpdater implements \Magento\Framework\View\Layout\Argument\UpdaterInterface
{
    private \Magento\Catalog\Helper\Data $productHelper;

    /**
     * CurrentProductIdUpdater constructor.
     * @param \Magento\Catalog\Helper\Data $productHelper
     */
    public function __construct(
        \Magento\Catalog\Helper\Data $productHelper
    ) {
        $this->productHelper = $productHelper;
    }

    /**
     * Set current product id to jsLayout for passing it to the Knockout component
     *
     * @param array $value
     * @return array
     */
    public function update($value): array
    {
        if ($product = $this->productHelper->getProduct()) {
            $value['components']['regularCustomerRequest']['children']['regularCustomerRequestForm']['config']
            ['productId'] = (int) $product->getId();
        }

        return $value;
    }
}
