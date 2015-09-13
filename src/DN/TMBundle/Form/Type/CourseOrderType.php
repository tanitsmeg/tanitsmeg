<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class CourseOrderType extends AbstractType {

//    private $container;
//
//    public function __construct(Container $container) {
//        $this->container = $container;
//    }
//
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('course', 'entity', array(
                    'label' => 'label.course',
                    'class' => 'DN\TMBundle\Entity\Course',
                    'required' => true,
                ))
                ->add('email', 'text', array(
                    'label' => 'label.email',
                    'required' => true,
                ))
                ->add('phone', 'text', array(
                    'label' => 'label.phone',
                    'required' => false,
                ))
                ->add('fullname', 'text', array(
                    'label' => 'label.fullname',
                    'required' => false,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Save',
                ))
        ;
    }

    public function getName() {
        return 'course_order';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\CourseOrder',
        ));
    }

}
