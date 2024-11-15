<?php
declare(strict_types=1);

namespace Topalovic\Narudzbine\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Topalovic\Narudzbine\Model\Order\StatusChanger;
use Magento\Framework\Controller\Result\JsonFactory;

class ChangeStatus extends Action
{
    const ADMIN_RESOURCE = 'Magento_Sales::actions_edit';

    protected OrderRepositoryInterface $orderRepository;
    protected StatusChanger $statusChanger;
    protected JsonFactory $resultJsonFactory;

    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        StatusChanger $statusChanger,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->orderRepository = $orderRepository;
        $this->statusChanger = $statusChanger;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        
        if (!$this->getRequest()->isPost()) {
            return $resultJson->setData(['error' => 'Invalid request method']);
        }

        $orderId = $this->getRequest()->getParam('order_id');
        $newStatus = $this->getRequest()->getParam('status');

        if (!$orderId || !$newStatus) {
            return $resultJson->setData(['error' => 'Missing required parameters']);
        }

        try {
            $order = $this->orderRepository->get($orderId);
            $this->statusChanger->execute($order, $newStatus);
            return $resultJson->setData(['success' => true]);
        } catch (\Exception $e) {
            return $resultJson->setData(['error' => $e->getMessage()]);
        }
    }
}
