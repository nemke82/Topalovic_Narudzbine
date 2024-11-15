<?php
declare(strict_types=1);

namespace Topalovic\Narudzbine\Model\Order;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

class StatusChanger
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function execute(Order $order, string $newStatus): void
    {
        $order->setState($newStatus)
            ->setStatus($newStatus);
        $this->orderRepository->save($order);
    }
}
