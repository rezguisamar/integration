<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Ensure correct namespace


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('startDate')
            ->add('endDate')
            ->add('capacity')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'donnation' => 'donnation', // Replace 'category1_value' with the actual value you want to store
                    'action' => 'action', // Replace 'category2_value' with the actual value you want to store
                    // Add more categories as needed
                ],
                'placeholder' => 'Choose a category', // Optional placeholder text
                // Additional options as needed
            ]);           
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
