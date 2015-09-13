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

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        switch ($options['flow_step']) {
            case 1:
                $validValues = array(2, 4);
                $builder->add('numberOfWheels', 'choice', array(
                    'choices' => array_combine($validValues, $validValues),
                    'empty_value' => '',
                ));
                break;
            case 2:
                $builder->add('engine', 'form_type_vehicleEngine', array(
                    'empty_value' => '',
                ));
                break;
        }
        $builder
                ->add('courseTimes', 'collection', array(
                    'label' => 'label.courseTimes',
                    'type' => $this->container->get('dn.tm.form.type.course_time'),
                    'required' => false,
                ))
                ->add('email', 'text', array(
                    'label' => 'label.email',
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
        return 'course_order';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\CourseOrder',
        ));
    }

}
