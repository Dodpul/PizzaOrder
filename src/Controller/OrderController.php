<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Orders;
use App\Entity\OrderItem;
use App\Entity\Pizzas;
use App\Entity\Sizes;
use App\Entity\Toppings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order_form')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Load repositories once to reduce code duplication
        $pizzaRepo = $em->getRepository(Pizzas::class);
        $sizeRepo = $em->getRepository(Sizes::class);
        $toppingRepo = $em->getRepository(Toppings::class);
        $customerRepo = $em->getRepository(Customer::class);

        // Load pizza, size, topping options
        $pizzas = $pizzaRepo->findAll();
        $sizes = $sizeRepo->findAll();
        $toppings = $toppingRepo->findAll();

        // Create the form manually (can be replaced with FormType later)
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('pizza', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($p) => $p->getName(), $pizzas),
                    array_map(fn($p) => $p->getId(), $pizzas)
                )
            ])
            ->add('size', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($s) => $s->getSize(), $sizes),
                    array_map(fn($s) => $s->getId(), $sizes)
                )
            ])
            ->add('toppings', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($t) => $t->getDescription(), $toppings),
                    array_map(fn($t) => $t->getId(), $toppings)
                ),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('comment', TextareaType::class, ['required' => false])
            ->add('submit', SubmitType::class, ['label' => 'Place Order'])
            ->getForm();

        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $name = trim($data['name']);
            $email = trim($data['email']);

            // Validation for name and email
            if (empty($name)) {
                $errors[] = 'Name is required.';
            }

            if (empty($email)) {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }

            if (empty($errors) && $form->isValid()) {
                // Find existing customer or create new
                $customer = $customerRepo->findOneBy(['email' => $email]);
                if (!$customer) {
                    $customer = new Customer();
                    $customer->setName($name);
                    $customer->setEmail($email);
                    $em->persist($customer);
                }

                // Create Order entity
                $order = new Orders();
                $order->setCustomer($customer);
                $order->setCustomerComment($data['comment']);
                $order->setSize($sizeRepo->find($data['size']));
                $order->setPizza($pizzaRepo->find($data['pizza']));
                $em->persist($order);

                // Create OrderItem entity
                $orderItem = new OrderItem();
                $orderItem->setOrder($order);
                $orderItem->setPizza($pizzaRepo->find($data['pizza']));
                $orderItem->setSize($sizeRepo->find($data['size']));

                // Add toppings (ManyToMany)
                foreach ($data['toppings'] as $toppingId) {
                    $topping = $toppingRepo->find($toppingId);
                    if ($topping) {
                        $orderItem->addTopping($topping);
                    }
                }

                $em->persist($orderItem);

                $em->flush();

                $this->addFlash('success', 'Order placed successfully!');
                return $this->redirectToRoute('order_form');
            }
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }
}
