<?php

namespace Engelsystem\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['data' => $options['lastUsername']])
            ->add('password', PasswordType::class)
            ->add('login', SubmitType::class)
            ->setAction($options['action']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'lastUsername' => '',
            'action' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }


}
