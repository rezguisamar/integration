<?php

namespace App\Form;

use App\Entity\Donation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Donation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('address')
            //->add('date')
            ->add('firstName')
            ->add('lastName')
            ->add('amount')

            ->add('phoneNumber')
            ->add('save', SubmitType::class, [
                'label' => 'Donate', // This sets the label for the submit button
                'attr' => ['class' => 'btn btn-primary py-3 px-4']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
