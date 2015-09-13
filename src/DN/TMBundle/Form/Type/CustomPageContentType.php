<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;

class CustomPageContentType extends ImmutableArrayType {

    public function getParent() {
        return 'sonata_type_immutable_array';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'richtext',
            )
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('text', null, array(
                    'required' => false,
                ))
                ->add('search', 'submit')
        ;
    }

    public function getName() {
        return 'custom_page_content_type';
    }

}
