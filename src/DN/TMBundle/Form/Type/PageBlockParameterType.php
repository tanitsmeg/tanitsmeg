<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageBlockParameterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('key', 'text', array('label' => 'label.key'))
                ->add('value', 'text', array('label' => 'label.value'))
        ;
    }

    public function getName() {
        return 'page_block_parameter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\PageBlockParameter',
        ));
    }

}
