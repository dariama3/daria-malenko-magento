<?php
declare(strict_types=1);

namespace Dariam\ControllerDemos\Controller\Demos;

use Magento\Framework\Controller\Result\Forward;

class ForwardResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory;

    /**
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->forwardFactory = $forwardFactory;
    }

    /**
     * @return Forward
     */
    public function execute(): Forward
    {
        $result = $this->forwardFactory->create();

        return $result->forward('jsonresponsedemo');
    }
}
