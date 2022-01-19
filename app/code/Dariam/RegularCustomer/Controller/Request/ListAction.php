<?php
declare(strict_types=1);

namespace Dariam\RegularCustomer\Controller\Request;

use Magento\Framework\Controller\ResultInterface;

class ListAction implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * @var \Magento\Customer\Model\Url $url
     */
    private \Magento\Customer\Model\Url $url;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Url $url
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Url $url
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
        $this->redirectFactory = $redirectFactory;
        $this->customerSession = $customerSession;
        $this->url = $url;
    }

    /**
     * List customer requests
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (!$this->customerSession->isLoggedIn()) {
            return $this->redirectFactory->create()->setUrl(
                $this->url->getLoginUrl()
            );
        }

        return $this->pageResponseFactory->create();
    }
}
