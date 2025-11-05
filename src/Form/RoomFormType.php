<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Rooms;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roomNumber')
            ->add('price')
            ->add('type')
            ->add('booking', EntityType::class, [
                'class' => Booking::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rooms::class,
        ]);
    }
}
