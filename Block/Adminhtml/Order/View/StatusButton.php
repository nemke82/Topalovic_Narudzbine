<?php
declare(strict_types=1);

namespace Topalovic\Narudzbine\Block\Adminhtml\Order\View;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order\Config;
use Magento\Framework\Exception\NoSuchEntityException;

class StatusButton extends Template
{
    protected $coreRegistry;
    protected $orderRepository;
    protected $orderConfig;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        OrderRepositoryInterface $orderRepository,
        Config $orderConfig,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->orderRepository = $orderRepository;
        $this->orderConfig = $orderConfig;
        parent::__construct($context, $data);
    }

    /**
     * Get current order
     *
     * @return \Magento\Sales\Model\Order|null
     */
    public function getOrder()
    {
        try {
            if ($orderId = $this->getRequest()->getParam('order_id')) {
                return $this->orderRepository->get($orderId);
            }
        } catch (NoSuchEntityException $e) {
            return null;
        }
        return null;
    }

    /**
     * Get order ID
     *
     * @return int|null
     */
    public function getOrderId()
    {
        $order = $this->getOrder();
        return $order ? $order->getId() : null;
    }

    /**
     * Get status change URL
     *
     * @return string
     */
    public function getChangeStatusUrl()
    {
        return $this->getUrl('orderstatus/order/changestatus');
    }

    /**
     * Get available statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return $this->orderConfig->getStatuses();
    }

    /**
     * Get current status
     *
     * @return string
     */
    public function getCurrentStatus()
    {
        $order = $this->getOrder();
        return $order ? $order->getStatus() : '';
    }
}
