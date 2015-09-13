<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use DN\TMBundle\Model\SiteSearch;

class AdvancedSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('text', 'text', array(
                'required' => false,
            ))
            ->add('isProduct', 'checkbox', array(
                'required' => false,
            ))
            ->add('isContent', 'checkbox', array(
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
            ->add('category', 'entity', array(
                'required' => false,
                'empty_value' => 'wählen',
                'class' => 'DNTMBundle:Category',
            ))
            ->add('sort','choice', array(
                'required' => false,
                'empty_value' => 'Relevancy',
                'choices' => SiteSearch::$sortChoices,
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
            'data_class' => 'DN\TMBundle\Model\SiteSearch',
        ));
    }

    public function getName() {
        return 'advanced_search_type';
    }
}
