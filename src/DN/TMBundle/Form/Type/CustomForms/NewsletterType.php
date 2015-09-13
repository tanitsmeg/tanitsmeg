<?php

namespace DN\TMBundle\Form\Type\CustomForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsletterType extends AbstractType {

    public function getName() {
        return 'newsletter';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // each "add" means a new field on the form (followed by () including the parameters)
        // the "submit" field at the end is always needed, the others can be modified, deleted
        $builder
                // name of the field, type of the field (now: choice field (select))
                ->add('anrede', 'choice', array(
                    // label
                    'label' => 'Herr/Frau',
                    // options
                    'choices' => array(
                        // id => displayed value
                        'herr' => 'Herr',
                        'frau' => 'Frau',
                    ),
                    // default value
                    'data' => 'herr',
                    // is required or not (true/false)
                    'required' => false,
                ))
                // next form field with type of "text"
                ->add('vorname', 'text', array(
                    'label' => 'Vorname',
                    'required' => false,
                ))
                ->add('nachname', 'text', array(
                    'label' => 'Nachname',
                    'required' => false,
                ))
                ->add('unternehmen', 'text', array(
                    'label' => 'Unternehmen',
                    'required' => false,
                ))
                ->add('position', 'text', array(
                    'label' => 'Position im Unternehmen',
                    'required' => false,
                ))
                ->add('strasse', 'text', array(
                    'label' => 'Straße/Nr.',
                    'required' => false,
                ))
                ->add('postleitzahl', 'text', array(
                    'label' => 'Postleitzahl',
                    'required' => false,
                ))
                ->add('ort', 'text', array(
                    'label' => 'Ort',
                    'required' => false,
                ))
                ->add('land', 'text', array(
                    'label' => 'Land',
                    'required' => false,
                ))
                ->add('telefonnummer', 'text', array(
                    'label' => 'Telefonnummer',
                    'required' => false,
                ))
                ->add('email', 'email', array(
                    'label' => 'Email',
                    'required' => true,
                ))
                ->add('personlicheNachrichten', 'textarea', array(
                    'label' => 'Persönliche Nachrichten',
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
