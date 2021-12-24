<?php
declare(strict_types=1);

namespace Dariam\ControllerDemos\Controller\Demos;

use Magento\Framework\View\Result\Page;

class PageResponseDemo implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    private \Magento\Framework\View\Result\PageFactory $pageFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(\Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    /**
     * Page result demo: https://daria-malenko-magento.local/dariam-controller-demos/demos/pageresponse
     *
     * @return Page
     */
    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
