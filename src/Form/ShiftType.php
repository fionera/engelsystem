<?php

namespace Engelsystem\Form;

use Engelsystem\Entity\Shift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('start')
            ->add('end')
            ->add('url')
            ->add('psid')
            ->add('createdAtTimestamp')
            ->add('editedAtTimestamp')
            ->add('room')
            ->add('shiftType')
            ->add('createdByUser')
            ->add('editedByUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shift::class,
        ]);
    }
}
