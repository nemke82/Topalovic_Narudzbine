<?php
declare(strict_types=1);

namespace Topalovic\Narudzbine\Block\Adminhtml\Order\View;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Registry;

class StatusButton extends Template
{
    protected $coreRegistry;
    protected $orderRepository;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    public function getOrderId()
    {
        $order = $this->getOrder();
        return $order ? $order->getId() : null;
    }

    public function getChangeStatusUrl()
    {
        return $this->getUrl('orderstatus/order/changestatus');
    }
}
