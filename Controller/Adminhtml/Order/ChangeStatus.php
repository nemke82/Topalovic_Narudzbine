<?php
declare(strict_types=1);

namespace Topalovic\Narudzbine\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Topalovic\Narudzbine\Model\Order\StatusChanger;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Sales\Model\Order\Config as OrderConfig;
use Magento\Framework\Exception\NoSuchEntityException;

class ChangeStatus extends Action
{
    const ADMIN_RESOURCE = 'Magento_Sales::actions_edit';

    protected OrderRepositoryInterface $orderRepository;
    protected StatusChanger $statusChanger;
    protected JsonFactory $resultJsonFactory;
    protected OrderConfig $orderConfig;

    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        StatusChanger $statusChanger,
        JsonFactory $resultJsonFactory,
        OrderConfig $orderConfig
    ) {
        parent::__construct($context);
        $this->orderRepository = $orderRepository;
        $this->statusChanger = $statusChanger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->orderConfig = $orderConfig;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        
        if (!$this->getRequest()->isPost()) {
            return $resultJson->setData(['error' => __('Invalid request method')]);
        }

        try {
            $orderId = (int)$this->getRequest()->getParam('order_id');
            $newStatus = $this->getRequest()->getParam('status');

            if (!$orderId || !$newStatus) {
                throw new \InvalidArgumentException(__('Missing required parameters'));
            }

            // Validate if status exists
            $availableStatuses = $this->orderConfig->getStatuses();
            if (!isset($availableStatuses[$newStatus])) {
                throw new \InvalidArgumentException(__('Invalid status code'));
            }

            $order = $this->orderRepository->get($orderId);
            $this->statusChanger->execute($order, $newStatus);
            
            return $resultJson->setData(['success' => true]);
        } catch (NoSuchEntityException $e) {
            return $resultJson->setData(['error' => __('Order not found')]);
        } catch (\Exception $e) {
            return $resultJson->setData(['error' => $e->getMessage()]);
        }
    }
}
