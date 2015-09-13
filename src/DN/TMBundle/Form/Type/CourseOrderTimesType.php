<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class CourseOrderTimesType extends AbstractType {

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'text', array(
                    'label' => 'label.id',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('times', 'text', array(
                    'label' => 'label.title',
                    'required' => true,
                ))
                ->add('description', 'textarea', array(
                    'label' => 'label.description',
                    'required' => false,
                ))
                ->add('description2', 'textarea', array(
                    'label' => 'label.description2',
                    'required' => false,
                ))
                ->add('description3', 'textarea', array(
                    'label' => 'label.description3',
                    'required' => false,
                ))
                ->add('courseTimes', 'collection', array(
                    'label' => 'label.courseTimes',
                    'type' => $this->container->get('dn.tm.form.type.course_time'),
                    'required' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                ->add('locations', 'collection', array(
                    'label' => 'label.locations',
                    'type' => $this->container->get('dn.tm.form.type.location'),
                    'required' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ))
                ->add('minParticipant', 'text', array(
                    'label' => 'label.minParticipant',
                    'required' => false,
                ))
                ->add('maxParticipant', 'text', array(
                    'label' => 'label.maxParticipant',
                    'required' => false,
                ))
                ->add('price', 'text', array(
                    'label' => 'label.description3',
                    'required' => false,
                ))
                ->add('priceType', 'text', array(
                    'label' => 'label.priceType',
                    'required' => false,
                ))
                ->add('tags', 'entity', array(
                    'label' => 'label.tags',
                    'class' => 'DN\TMBundle\Entity\Tag',
                    'property' => 'title',
//                    'expanded' => true,
                    'multiple' => true,
                    'required' => false,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Save',
                ))
        ;
    }

    public function getName() {
        return 'course_order_times';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\CourseOrder',
        ));
    }

}
