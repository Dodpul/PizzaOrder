<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrderController extends AbstractController
{
    #[Route('/admin/orders', name: 'admin_orders')]
    public function index(OrdersRepository $orderRepository): Response
    {
        // Fetch all orders (with their related entities)
        $orders = $orderRepository->findAll();

        return $this->render('admin/orders.html.twig', [
            'orders' => $orders,
        ]);
    }
}
