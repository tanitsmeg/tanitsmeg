<?php

namespace DN\TMBundle\Form\Type\CustomForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType {

    public function getName() {
        return 'contact';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // each "add" means a new field on the form (followed by () including the parameters)
        // the "submit" field at the end is always needed, the others can be modified, deleted
        $builder
                // next form field with type of "text"
                ->add('theme', 'text', array(
                    'label' => 'Thema',
                    'required' => false,
                ))
                ->add('message', 'textarea', array(
                    'label' => 'Ihre Nachricht an uns',
                    'required' => false,
                ))
                ->add('name', 'text', array(
                    'label' => 'Name des Unternehmen',
                    'required' => false,
                ))
                ->add('contact', 'text', array(
                    'label' => 'Ansprechpartner',
                    'required' => false,
                ))
                ->add('email', 'email', array(
                    'label' => 'Email',
                    'required' => false,
                ))
                ->add('zip', 'text', array(
                    'label' => 'Postleitzahl',
                    'required' => false,
                ))
                ->add('phone', 'text', array(
                    'label' => 'Telefon',
                    'required' => false,
                ))
                ->add('fax', 'text', array(
                    'label' => 'Fax',
                    'required' => false,
                ))
                ->add('address', 'text', array(
                    'label' => 'Adresse',
                    'required' => false,
                ))
                ->add('city', 'text', array(
                    'label' => 'Plz / Ort',
                    'required' => false,
                ))
                ->add('country', 'text', array(
                    'label' => 'Land',
                    'required' => false,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Senden',
                ))
//                ->add('save', 'button', array(
//                    'attr' => array('class' => 'custom-form-submit'),
//                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
        ));
    }

}
