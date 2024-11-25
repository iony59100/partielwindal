<?php

namespace App\Form;

use App\Entity\Gardes;
use App\Entity\Infirmier;
use App\Entity\Services;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GardesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('service', EntityType::class, [
                'class' => Services::class,
                'choice_label' => 'id',
            ])
            ->add('infirmier', EntityType::class, [
                'class' => Infirmier::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gardes::class,
        ]);
    }
}
