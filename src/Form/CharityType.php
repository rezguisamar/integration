<?php

namespace App\Form;

use App\Entity\Charity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Type;

use function PHPSTORM_META\type;

class CharityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_of_charity', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]+$/',
                        'message' => 'The name of the charity must contain only alphabetic characters.',
                    ]),
                ],
            ])
            ->add('amount_donated', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type([
                        'type' => 'numeric',
                    ]),
                ],

            ])
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,


            ])
            ->add('last_date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true, // Render as HTML5 date input
                'format' => 'yyyy-MM-dd', // Specify the date format,
                'data' => new \DateTime(), // Set default value to current date
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d'),

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Charity::class,
        ]);
    }
}
