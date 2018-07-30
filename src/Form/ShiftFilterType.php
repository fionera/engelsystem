<?php

namespace Engelsystem\Form;

use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftFilterType extends AbstractType
{
    /**
     * @var array
     */
    private $eventDays;

    /**
     * ShiftFilterType constructor.
     */
    public function __construct(array $eventDays)
    {
        $this->eventDays = $eventDays;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from_date', ChoiceType::class, [
                'choices' => array_combine($this->eventDays, $this->eventDays),
            ])
            ->add('from_time', TimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'input' => 'datetime',
            ])
            ->add('to_date', ChoiceType::class, [
                'choices' => array_combine($this->eventDays, $this->eventDays),
            ])
            ->add('to_time', TimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'input' => 'datetime',
            ])
            ->add('rooms', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'class' => Room::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('angelTypes', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'class' => AngelType::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('occupancy_free', CheckboxType::class, [
                'required' => false
            ])
            ->add('occupancy_occupied', CheckboxType::class, [
                'required' => false
            ])
            ->add('filter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
