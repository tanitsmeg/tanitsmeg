<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DN\TMBundle\Entity\CourseTime;

class LocationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'label.name',
                    'required' => false,
                ))
                ->add('description', 'text', array(
                    'label' => 'label.description',
                    'required' => false,
                ))
                ->add('city', 'text', array(
                    'label' => 'label.city',
                    'required' => false,
                ))
                ->add('street', 'text', array(
                    'label' => 'label.street',
                    'required' => false,
                ))
                ->add('number', 'text', array(
                    'label' => 'label.number',
                    'required' => false,
                ))
        ;
    }

    public function getName() {
        return 'location';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\Location',
        ));
    }

}
