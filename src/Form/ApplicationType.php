<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\File; // Add this line to import the File constraint


class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Email cannot be empty',
                    ]),
                    new Regex([
                        'pattern' => '/^[^\s@]+@[^\s@]+\.[^\s@]+$/', // expression régulière à vérifier
                        'message' => 'Email address invalid!',
                    ]),
                ],
            ])

            ->add('pdf', FileType::class, [
                'label' => 'PDF File',
                'mapped' => false, // This field is not mapped to an entity property
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please upload a PDF file',
                    ]),
                    new File([
                        'maxSize' => '1024k', // Adjust maximum file size if needed
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
