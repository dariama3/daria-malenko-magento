<?php
declare(strict_types=1);

namespace Dariam\ControllerDemos\Controller\Demos;

use Magento\Framework\Controller\Result\Json;

class JsonResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        $this->request = $request;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->jsonFactory->create();

        return $result->setData([
            'vendor' => $this->request->getParam('vendor'),
            'module' => $this->request->getParam('module'),
        ]);
    }
}
