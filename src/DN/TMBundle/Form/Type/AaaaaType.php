<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use DN\TMBundle\Model\SiteSearch;

class AaaaaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('text', 'text', array(
                'required' => false,
            ))
            ->add('checkbox', 'checkbox', array(
                'required' => false,
            ))
            ->add('choice1', 'choice', array(
                'required' => false,
                'choices' => array(1,2,3,4),
                'multiple'  => false,
                'expanded'  => false,
            ))
            ->add('choice2', 'choice', array(
                'required' => false,
                'choices' => array(1,2,3,4),
                'multiple'  => true,
                'expanded'  => false,
            ))
            ->add('choice3', 'choice', array(
                'required' => false,
                'choices' => array(1,2,3,4),
                'multiple'  => false,
                'expanded'  => true,
            ))
            ->add('choice4', 'choice', array(
                'required' => false,
                'choices' => array(1,2,3,4),
                'multiple'  => true,
                'expanded'  => true,
            ))
            ->add('textarea', 'textarea', array(
                'required' => false,
            ))
            ->add('email', 'email', array(
                'required' => false,
            ))
            ->add('integer', 'integer', array(
                'required' => false,
            ))
            ->add('money', 'money', array(
                'required' => false,
            ))
            ->add('number', 'number', array(
                'required' => false,
            ))
            ->add('password', 'password', array(
                'required' => false,
            ))
            ->add('search', 'search', array(
                'required' => false,
            ))
            ->add('url', 'url', array(
                'required' => false,
            ))
            ->add('country', 'country', array(
                'required' => false,
            ))
            ->add('language', 'language', array(
                'required' => false,
            ))
            ->add('locale', 'locale', array(
                'required' => false,
            ))
            ->add('timezone', 'timezone', array(
                'required' => false,
            ))
            ->add('currency', 'currency', array(
                'required' => false,
            ))
            ->add('date', 'date', array(
                'required' => false,
            ))
            ->add('datetime', 'datetime', array(
                'required' => false,
            ))
            ->add('time', 'time', array(
                'required' => false,
            ))
            ->add('birthday', 'birthday')
            ->add('file', 'file', array(
                'required' => false,
            ))
            ->add('radio', 'radio', array(
                'required' => false,
            ))
            ->add('collection', 'collection', array(
                'required' => false,
                'type'   => 'email',
            ))
            ->add('repeated', 'repeated', array(
                'required' => false,
                'type'   => 'text',
            ))
            ->add('button', 'button')
            ->add('reset', 'reset')
            ->add('page', 'hidden')
            ->add('submit','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            // avoid to pass the csrf token in the url (but it's not protected anymore)
            'csrf_protection' => false,
        ));
    }

    public function getName() {
        return 'aaaaa_type';
    }
}
