<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DN\TMBundle\Entity\CourseTime;

class CourseTimeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('description', 'textarea', array(
                    'label' => 'label.description',
                    'required' => false,
                ))
                ->add('from','date',array(
                    'label' => 'label.date_from',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => array('class' => 'date')
                 ))
                ->add('to','date',array(
                    'label' => 'label.date_to',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => array('class' => 'date')
                 ))
        ;
    }

    public function getName() {
        return 'course_time';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\CourseTime',
        ));
    }

}
