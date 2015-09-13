<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class CategorySEOType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('page_type', 'choice', array(
                    'label' => 'label.type',
                    'required' => true,
                    'choices' => array(
                        'product' => 'product',
                        'article' => 'article',
                        'news' => 'news',
                        'video' => 'video',
                        'trainer' => 'trainer',
                        'faq' => 'faq',
                    )
                ))
                ->add('overviewCategory', 'entity', array(
                    'class' => 'DN\TMBundle\Entity\Category',
                    'label' => 'label.category',
                    'required' => true,
                    'property' => 'detailedName',
                ))
                ->add('seoTitle', 'text', array(
                    'label' => 'label.seo title',
                    'required' => false,
                ))
                ->add('seoText', 'textarea', array(
                    'label' => 'label.seo description',
                    'required' => false,
                ))
        ;
    }

    public function getName() {
        return 'category_seo_type';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\CategorySEO',
        ));
    }

}
