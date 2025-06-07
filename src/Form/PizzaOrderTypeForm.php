<?php

namespace App\Form;

use App\Entity\PizzaOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PizzaOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerName', TextType::class, [
                'label' => 'Your Name',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Pizza Size',
                'choices' => [
                    'Small' => 'small',
                    'Medium' => 'medium',
                    'Large' => 'large',
                ],
                'expanded' => true, // radio buttons
                'multiple' => false,
            ])
            ->add('ingredients', ChoiceType::class, [
                'label' => 'Ingredients',
                'choices' => [
                    'Cheese' => 'cheese',
                    'Pepperoni' => 'pepperoni',
                    'Mushrooms' => 'mushrooms',
                    'Onions' => 'onions',
                    'Olives' => 'olives',
                ],
                'multiple' => true, // allow multiple selection (checkboxes)
                'expanded' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Additional Comments',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PizzaOrder::class,
        ]);
    }
}
