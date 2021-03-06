<?php
declare(strict_types=1);

namespace Dariam\ControllerDemos\Controller\Demos;

use Magento\Framework\Controller\Result\Redirect;

class RedirectResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    ) {
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Redirects to github repository.
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $result = $this->redirectFactory->create();

        return $result->setUrl('https://github.com/dariama3/daria-malenko-magento');
    }
}
