<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use DN\TMBundle\Model\SiteSearch;

class QuickSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('text', 'text', array(
                'required' => false,
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
        return 'quick_search_type';
    }
}
