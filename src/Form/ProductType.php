<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productname')
            ->add('productquantity')
            ->add('productsize',ChoiceType::class,[
                'choices'=>[
                    'S'=>'Small',
                    'M'=>'M',
                    'L'=>'L',
                    'XL'=>'XL',
                    'XXL'=>'XXL'
                    ]
])
            ->add('productprice')
            ->add('productdescription')
            ->add('productimg')
            ->add('productdisponibility', null, [
                'label' => 'Disponibility',
                'required' => false, // Make it optional
                'disabled' => !$options['include_productdisponibility_field'], // Disable if not included
            ])
        ;
    }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Product::class,
                'include_productdisponibility_field' => true, // Default value
            ]);
    
            $resolver->setAllowedTypes('include_productdisponibility_field', 'bool');
        }

    }
