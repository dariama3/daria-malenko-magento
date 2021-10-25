<?php
declare(strict_types=1);

namespace Dariam\ControllerDemos\Controller\Demos;

use Magento\Framework\Controller\Result\Raw;

class RawResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\Controller\Result\RawFactory $rawFactory;

    /**
     * @param \Magento\Framework\Controller\Result\RawFactory $rawFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RawFactory $rawFactory
    ) {
        $this->rawFactory = $rawFactory;
    }

    /**
     * @return Raw
     */
    public function execute(): Raw
    {
        $result = $this->rawFactory->create();

        return $result->setHeader('Content-Type', 'text/html')
            ->setContents(<<<HTML
<ul>
    <li><a href="/dariam-controller-demos/demos/redirectresponsedemo" target="_blank">RedirectResponseDemo</a></li>
    <li><a href="/dariam-controller-demos/demos/jsonresponsedemo">JsonResponseDemo</a></li>
    <li><a href="/dariam-controller-demos/demos/forwardresponsedemo">ForwardResponseDemo</a></li>
</ul>
<form method="GET" action="/dariam-controller-demos/demos/jsonresponsedemo">
    <label>
        Vendor
        <input type="text" name="vendor" value="Dariam">
    </label>
    <label>
        Module
        <input type="text" name="module" value="ControllerDemos">
    </label>
    <button type="submit">Submit</button>
</form>
HTML
);
    }
}
