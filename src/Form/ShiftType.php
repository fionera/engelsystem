<?php

namespace Engelsystem\Form;

use Engelsystem\Entity\Room;
use Engelsystem\Entity\Shift;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shiftType', EntityType::class, [
                'class' => \Engelsystem\Entity\ShiftType::class
            ])
            ->add('name', TextType::class)
            ->add('room', EntityType::class, [
                'class' => Room::class
            ])
            ->add('start', DateTimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => false,
                'html5' => false
            ])
            ->add('end', DateTimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => false,
                'html5' => false
            ])
            ->add('neededAngelTypes', CollectionType::class, [
                'entry_type' => NeededAngelTypesType::class,
                'allow_add' => true
            ])
            ->add('preview', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shift::class,
        ]);
    }
}
