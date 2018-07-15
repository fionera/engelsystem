<?php

namespace Engelsystem\Form;

use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\User;
use Engelsystem\Entity\UserAngelTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User|null $user */
        $user = $builder->getData();

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
            ->add('age', TextType::class, ['required' => false])
            ->add('hometown', TextType::class, ['required' => false])
            ->add('angelTypes', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'class' => AngelType::class,
                'choice_label' => 'name',
                'mapped' => false,
                'choice_attr' => function (AngelType $angelType) use ($user) {
                    $attributes = [
                        'disabled' => $angelType->getNoSelfSignup()
                    ];

                    if ($user !== null) {
                        /** @var UserAngelTypes $userAngelType */
                        foreach ($angelType->getUserAngelTypes()->toArray() as $userAngelType) {
                            if ($userAngelType->getUser()->getId() === $user->getId()) {
                                $attributes['checked'] = 'checked';
                            }
                        }

                    }

                    return $attributes;
                },
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
