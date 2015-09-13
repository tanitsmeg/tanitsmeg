<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class TeacherDataType extends AbstractType {

//    private $container;
//
//    public function __construct(Container $container) {
//        $this->container = $container;
//    }
//
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'név',
                    'required' => false,
                ))
                ->add('email', 'text', array(
                    'label' => 'email',
                    'required' => false,
                ))
                ->add('phone', 'text', array(
                    'label' => 'phone',
                    'required' => false,
                ))
                ->add('city', 'text', array(
                    'label' => 'city',
                    'required' => false,
                ))
                ->add('description', 'text', array(
                    'label' => 'description',
                    'required' => false,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Save',
                ))
        ;
    }

    public function getName() {
        return 'teacher_data';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\User',
        ));
    }

}
