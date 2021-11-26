<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \Dariam\RegularCustomer\Model\RegularCustomerRequest::class,
            \Dariam\RegularCustomer\Model\ResourceModel\RegularCustomerRequest::class
        );
    }
}
