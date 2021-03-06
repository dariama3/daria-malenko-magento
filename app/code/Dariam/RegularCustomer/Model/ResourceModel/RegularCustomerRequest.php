<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Model\ResourceModel;

class RegularCustomerRequest extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('dariam_regular_customer_request', 'request_id');
    }
}
