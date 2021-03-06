<?php

namespace Engelsystem\Form;

use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['required' => true])
            ->add('email', EmailType::class, ['required' => true])
            ->add('dect', TextType::class, ['required' => false])
            ->add('mobile', TelType::class, ['required' => false])
            ->add('phone', TelType::class, ['required' => false])
            ->add('emailShiftinfo', CheckboxType::class, ['required' => false])
            ->add('emailByHumanAllowed', CheckboxType::class, ['required' => false])
            ->add('plannedArrivalDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                ]
            ])
            ->add('jabber', TextType::class, ['required' => false])
            ->add('size', ChoiceType::class, [
                'choices' => [
                    'XXS' => 'XXS',
                    'XS' => 'XS',
                    'S' => 'S',
                ], 'required' => true
            ])
            ->add('prename', TextType::class, ['required' => false])
            ->add('surname', TextType::class, ['required' => false])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ))
            ->add('age', TextType::class, ['required' => false])
            ->add('hometown', TextType::class, ['required' => false])
            ->add('angelTypes', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'class' => AngelType::class,
                'choice_label' => 'name',
                'mapped' => false,
                'choice_attr' => function (AngelType $angelType) {
                    $attributes = [
                        'disabled' => $angelType->getNoSelfSignup()
                    ];

                    return $attributes;
                },
            ])
            ->add('register', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
