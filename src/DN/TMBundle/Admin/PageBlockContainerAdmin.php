<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use DN\TMBundle\Form\Type\PageBlockType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class PageBlockContainerAdmin extends Admin {

    protected $translationDomain = 'messages';
    private $container;

    public function __construct($code, $class, $baseControllerName, $container = null) {
        parent::__construct($code, $class, $baseControllerName);

        $this->container = $container;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
//        $container = $this->getConfigurationPool()->getContainer();

        $ptHints = '';
        $paramPageTypes = $this->container->getParameter('page_types');
        $i = 0;
        foreach ($paramPageTypes as $key => $ppt) {
            $ptHints .= $key;
            if ($i < count($paramPageTypes) - 1) {
                $ptHints .= ', ';
            }
            $i++;
        }

        $formMapper
            ->tab('General')
                ->with('Product')
                    ->add('id', 'text', array(
                        'label' => 'label.id',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('title', 'text', array(
                        'label' => 'label.title',
                        'required' => false,
                    ))
                    ->add('pageType', 'text', array(
                        'label' => 'label.effectedPageTypes' . ' (' . $ptHints . ')',
                        'required' => false,
                        'attr' => array('class' => 'bfi-page-types'),
                    ))
    //                ->add('pageType', 'sonata_type_model', array(
    //                    'multiple' => true,
    //                    'label' => 'label.effectedPageTypes',
    //                    'required' => false,
    //                    'btn_add' => false,
    //                ))
                    ->add('pageIds', 'text', array(
                        'label' => 'label.effectedPageIds',
                        'required' => false,
                        'attr' => array('class' => 'bfi-page-ids', 'disabled' => 'disabled'),
                    ))
    //                ->add('pagePaths', 'entity', array(
    //                    'class' => 'DNTMBundle:PagePath',
    //                    'multiple' => true,
    //                    'label' => 'label.effectedPagePaths',
    //                    'required' => false,
    //                ))
                    ->add('categories', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'label.categories',
                        'required' => false,
                        'property' => 'detailedName',
                        'btn_add' => false,
                    ))
                    ->add('active', null, array(
                        'label' => 'label.active',
                        'required' => false,
                    ))
                ->end()
            ->end()
            ->tab('General')
            ->with('Blocks')
                ->add('pageBlocks', 'collection', array(
                    'label' => 'label.displayedBlocks',
                    'type' => $this->container->get('dn.tm.form.type.page_block'),
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                ->end()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('pageType')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('title')
                ->add('pageType')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'Clone' => array(
                            'template' => 'DNTMBundle:Admin:list__action_clone.html.twig'
                        )
                    )
                ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->add('clone', $this->getRouterIdParameter() . '/clone');
    }

    public function preUpdate($object) {
        return $this->convertIds($object);
    }
    
    public function prePersist($object) {
        return $this->convertIds($object);
    }
    
    private function convertIds($object) {
        $typesReceived = explode(',', $object->getPageType());
        $idsReceived = explode(',', $object->getPageIds());
        $pageTypes = array();
        $pageIds = array();

        $paramPageTypes = $this->container->getParameter('page_types');

        foreach ($typesReceived as $tr) {
            $t = trim($tr);
            if (isset($paramPageTypes[$t])) {
                $pageTypes[] = $t;
            }
        }

        foreach ($idsReceived as $tr) {
            $t = trim($tr);
            $pageIds[] = $t;
        }

        $object->setPageType(json_encode($pageTypes));
        $object->setPageIds(json_encode($pageIds));

        return $object;
    }

}
