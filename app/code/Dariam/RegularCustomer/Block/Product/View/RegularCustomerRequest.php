<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Block\Product\View;

class RegularCustomerRequest extends \Magento\Framework\View\Element\Template
{
    private \Magento\Catalog\Helper\Data $productHelper;

    /**
     * RegularCustomerRequest constructor.
     * @param \Magento\Catalog\Helper\Data $productHelper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Helper\Data $productHelper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productHelper = $productHelper;
    }

    /**
     * Get cache key information incl. current product ID
     *
     * @return array
     */
    public function getCacheKeyInfo(): array
    {
        $cacheKey = parent::getCacheKeyInfo();

        if ($product = $this->productHelper->getProduct()) {
            $cacheKey['product_id'] = (int) $product->getId();
        }

        return $cacheKey;
    }
}
