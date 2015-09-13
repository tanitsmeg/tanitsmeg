<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CustomFormDataAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('id', 'text', array(
                    'label' => 'label.id',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('email', 'text', array(
                    'label' => 'label.email',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('created', 'sonata_type_datetime_picker', array(
                    'label' => 'label.appearanceDate',
                    'required' => false,
                    'dp_side_by_side' => true,
                    'dp_use_current' => false,
                    'dp_use_seconds' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('formType', 'text', array(
                    'label' => 'label.type',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('data', 'textarea', array(
                    'label' => 'label.content',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                    'attr' => array('class' => 'bfi-form-data hidden'),
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('formType')
                ->add('email')
                ->add('created')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('formType')
                ->add('email')
                ->add('created')
        ;
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
