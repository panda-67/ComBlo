<?php

namespace App\Form;

use App\Entity\Artikel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

 
class ArtikelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')            
            ->add('content', CKEditorType::class, [ 
                'label' => 'Deskripsi',                
                'config' => array(
                    'uiColor' => '#ffffff',
                    //...
                ),
            ])
            
            ->add('cover', FileType::class, [
                'label' => 'Cover (Image file, max 0.5 MB)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '524k',
                        'mimeTypes' => [
                            'image/*',                            
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image File!',
                    ]),
                ],
            ])
            ->add('created_on', DateType::class, [
                // 'placeholder' => [
                //     'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                //     'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                // ],
                'widget' => 'single_text',
                // 'html5' => false,
                // 'input'  => 'datetime',
                
            ])
            ->add('update_on', DateType::class, [
                'widget' => 'choice',
                'input' => 'datetime',
            ])     
            ->add('harga', MoneyType::class, [
                'divisor' => 1,
                'grouping' => true,                
                'currency' => 'IDR',
                'scale' => 2,
                'help' => 'Tanpa menambahkan titik/koma',
            ])
            ->add('harga_d', MoneyType::class, [
                'divisor' => 1,
                'grouping' => true,                
                'currency' => 'IDR',
                'scale' => 2,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artikel::class,
        ]);
    }
}
