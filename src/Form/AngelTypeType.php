<?php

namespace Engelsystem\Form;

use Engelsystem\Entity\AngelType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AngelTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('restricted')
            ->add('description')
            ->add('requiresDriverLicense')
            ->add('noSelfSignup')
            ->add('contactName')
            ->add('contactDect')
            ->add('contactEmail')
            ->add('showOnDashboard')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AngelType::class,
        ]);
    }
}
