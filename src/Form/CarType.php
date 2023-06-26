<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbSeats', IntegerType::class,array(
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 16px'
                )
            ))
            ->add('nbDoors', IntegerType::class,array(
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 16px'
                )
            ))
            ->add('name', TextType::class,array(
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 16px'
                )
            ))
            ->add('cost', NumberType::class,array(
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 16px'
                )
            ))
            ->add('category', EntityType::class, [
                'class' => CarCategory::class, // Remplace "Category" par le nom de ton entité Category
                'choice_label' => 'name', // Remplace "name" par la propriété utilisée comme libellé dans ton entité Category
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 16px'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
