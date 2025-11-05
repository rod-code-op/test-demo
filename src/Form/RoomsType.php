<?php

namespace App\Form;

use App\Entity\Rooms;
use App\Enum\RoomType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roomNumber', TextType::class, [
                'label' => 'Room Number',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Price per Night',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Room Type',
                'choices' => [
                    'Single' => RoomType::SINGLE,
                    'Double' => RoomType::DOUBLE,
                    'Suite' => RoomType::SUITE,
                ],
                'choice_label' => function ($choice) {
                    // Show readable labels
                    return ucfirst($choice->value);
                },
                'choice_value' => fn (?RoomType $type) => $type?->value,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rooms::class,
        ]);
    }
}
