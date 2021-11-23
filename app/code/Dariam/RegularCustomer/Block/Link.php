<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Block;

use Magento\Customer\Block\Account\SortLinkInterface;

class Link extends \Magento\Framework\View\Element\Html\Link implements SortLinkInterface
{
    /**
     * @return string
     */
    public function getHref()
    {
        return $this->getUrl('regular-customer/request/list');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Loyalty program');
    }

    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }
}
