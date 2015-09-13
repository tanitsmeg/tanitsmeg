<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class CourseType extends AbstractType {

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
                ->add('title', 'text', array(
                    'label' => 'label.title',
                    'required' => true,
                ))
                ->add('image', 'file', array(
                    'label' => 'label.upload_image',
                    'required' => false,
                ))
                ->add('description', 'textarea', array(
                    'label' => 'label.description',
                    'required' => false,
                ))
                ->add('description2', 'textarea', array(
                    'label' => 'label.offers',
                    'required' => false,
                ))
                ->add('description3', 'textarea', array(
                    'label' => 'label.information',
                    'required' => false,
                ))
                ->add('courseTimes', 'collection', array(
                    'label' => 'label.course_times',
                    'type' => $this->container->get('dn.tm.form.type.course_time'),
                    'required' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                ->add('addressZip', 'text', array(
                    'label' => 'label.address_zip',
                    'required' => false,
                ))
                ->add('addressCity', 'text', array(
                    'label' => 'label.address_city',
                    'required' => false,
                ))
                ->add('addressStreet', 'text', array(
                    'label' => 'label.address_street',
                    'required' => false,
                ))
                ->add('addressComment', 'text', array(
                    'label' => 'label.address_comment',
                    'required' => false,
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
//                ->add('tags', 'collection', array(
//                    'type' => new TagType(),
//                ))
                ->add('tags', 'entity', array(
                    'label' => 'label.tags',
                    'class' => 'DN\TMBundle\Entity\Tag',
                    'property' => 'title',
                    'expanded' => true,
                    'multiple' => true,
                    'required' => false,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Save',
                ))
        ;
    }

    public function getName() {
        return 'course';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\Course',
        ));
    }

}
