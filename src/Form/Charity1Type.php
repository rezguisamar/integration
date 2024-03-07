<?php

namespace App\Form;

use App\Entity\Charity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Charity1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_of_charity')
            ->add('amount_donated')
            // ->add('total_of_donation')
            ->add('last_date')
            ->add('picture');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Charity::class,
        ]);
    }
}
