<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiOrderController extends AbstractController
{
    #[Route('/api/orders', name: 'api_orders', methods: ['GET'])]
    public function index(OrdersRepository $ordersRepository): JsonResponse
    {
        $orders = $ordersRepository->findAll();

        $data = [];

        foreach ($orders as $order) {
            $items = [];
            foreach ($order->getOrderItems() as $item) {
                $toppings = [];
                foreach ($item->getToppings() as $topping) {
                    $toppings[] = $topping->getDescription();
                }

                $items[] = [
                    'pizza' => $item->getPizza()->getName(),
                    'size' => $item->getSize()->getSize(),
                    'toppings' => $toppings,
                    'comment' => $item->getComment(),
                ];
            }

            $data[] = [
                'id' => $order->getId(),
                'customer' => [
                    'name' => $order->getCustomer()->getName(),
                    'email' => $order->getCustomer()->getEmail(),
                ],
                'items' => $items,
                'customerComment' => $order->getCustomerComment(),
                'createdAt' => $order->getCreatedAt()
                    ->setTimezone(new \DateTimeZone('Europe/Sofia'))
                    ->format('Y-m-d H:i'),
            ];
        }

        return $this->json($data);
    }
}
