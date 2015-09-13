<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use DN\TMBundle\Model\CategorySearch;

class CategorySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('isProduct', 'checkbox', array(
                'required' => false,
            ))
            ->add('isInfoEvent', 'checkbox', array(
                'required' => false,
            ))
            ->add('productType', 'entity', array(
                'required' => false,
                'empty_value' => 'wählen',
                'class' => 'DNTMBundle:ProductType',
            ))
            ->add('dayTime', 'choice', array(
                'required' => false,
                'empty_value' => 'wählen',
                'choices'   => array(
                    'T' => 'Day',
                    'A' => 'Evening',
                    'W' => 'Weekend',
                ),
            ))
            ->add('subcategories', 'extended_entity', array(
                'required' => false,
                'empty_value' => 'wählen',
                'class' => 'DNTMBundle:Category',
                'choices' => $options['subcategories'],
                'choice_attributes' => array(
                    'data-slug' => 'slug',
                    'data-parent-slug' => 'parent.slug',
                ),
                'multiple'  => true,
                'expanded'  => true,
            ))
            ->add('sort','choice',array(
                'required' => false,
                'empty_value' => 'Relevancy',
                'choices' => CategorySearch::$sortChoices,
            ))
            ->add('page', 'hidden')
            ->add('search','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            // avoid to pass the csrf token in the url (but it's not protected anymore)
            'csrf_protection' => false,
            'data_class' => 'DN\TMBundle\Model\CategorySearch',
            'subcategories' => null,
        ));
    }

    public function getName() {
        return 'category_search_type';
    }
}
