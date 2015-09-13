<?php

namespace DN\TMBundle\Form\Type\CustomForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType {

    public function getName() {
        return 'question';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('anrede', 'choice', array(
                    'label' => 'Herr/Frau',
                    'choices' => array(
                        'herr' => 'Herr',
                        'frau' => 'Frau',
                    ),
                    'data' => 'herr',
                ))
                ->add('title', 'text', array(
                    'label' => 'Titel',
                    'required' => false,
                ))
                ->add('vorname', 'text', array(
                    'label' => 'Vorname',
                    'required' => true,
                ))
                ->add('nachname', 'text', array(
                    'label' => 'Nachname',
                    'required' => true,
                ))
                ->add('geburtsdatum', 'text', array(
                    'label' => 'Geburtsdatum',
                    'required' => false,
                ))
                ->add('email', 'email', array(
                    'label' => 'Email',
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
                ->add('unternehmenname', 'text', array(
                    'label' => 'Name des Unternehmen',
                    'required' => false,
                ))
                ->add('stuckzahl', 'text', array(
                    'label' => 'Gewünschte Stückzahl',
                    'required' => false,
                ))
                ->add('anrede', 'choice', array(
                    'label' => 'Herr/Frau',
                    'choices' => array(
                        'internet' => 'Internet',
                        'inserat' => 'Inserat',
                        'plakat' => 'Plakat',
                        'messe' => 'Messe',
                        'personlich' => 'Persönl. Empfehlung',
                    ),
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Senden',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
        ));
    }

}
