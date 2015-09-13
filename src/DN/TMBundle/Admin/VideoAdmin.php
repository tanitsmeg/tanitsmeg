<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class VideoAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->tab('General')
                ->with('Video')
                    ->add('id', 'text', array(
                        'label' => 'label.id',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('title', 'text', array('label' => 'label.title', 'required' => true))
                    ->add('subtitle', 'text', array('label' => 'label.subtitle', 'required' => false))
                    ->add('slug', 'text', array('label' => 'label.slug', 'required' => true))
                    ->add('embedCode', 'text', array('label' => 'label.embedCode', 'required' => true))
                    ->add('teaserImage', 'sonata_type_model_list', array(
                        'required' => false,
                        'label' => 'label.teaserImage',
                            ), array(
                        'link_parameters' => array('context' => 'article')
                    ))
                    ->add('teaserText', 'ckeditor', array(
                        'config' => array(
                            'stylesSet' => 'tm_styles',
                        ),
                        'label' => 'label.teaserText',
                        'required' => true,
                    ))
                    ->add('content', 'ckeditor', array(
                        'config' => array(
                            'stylesSet' => 'tm_styles',
                        ),
                        'label' => 'label.content',
                        'required' => false,
                    ))
                    ->add('category', 'entity', array(
                        'class' => 'DN\TMBundle\Entity\Category',
                        'label' => 'label.category',
                        'required' => false,
                        'property' => 'detailedName',
                    ))
                    ->add('subcategory', 'entity', array(
                        'class' => 'DN\TMBundle\Entity\Category',
                        'label' => 'label.subcategory',
                        'required' => false,
                        'property' => 'detailedName',
                    ))
                    ->add('additionalCategories', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'label.additionalCategories',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
                    ))
                ->end()
            ->end()
            ->tab('SEO')
                ->with('SEO data')
                    ->add('seoTitle', 'text', array(
                        'label' => 'label.seo title',
                        'required' => false,
                    ))
                    ->add('seoText', 'textarea', array(
                        'label' => 'label.seo description',
                        'required' => false,
                    ))
                    ->add('canonicalUrl', 'text', array('label' => 'label.canonicalUrl', 'required' => false))
                    ->add('noindex', null, array('label' => 'label.noindex', 'required' => false))
                    ->add('noarchive', null, array('label' => 'label.noarchive', 'required' => false))
                    ->add('nofollow', null, array('label' => 'label.nofollow', 'required' => false))
                    ->add('noydir', null, array('label' => 'label.noydir', 'required' => false))
                    ->add('noopd', null, array('label' => 'label.noopd', 'required' => false))
                    ->add('nosnippet', null, array('label' => 'label.nosnippet', 'required' => false))
                ->end()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('title')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('title')
        ;
    }

}
