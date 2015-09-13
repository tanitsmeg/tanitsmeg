<?php

namespace DN\TMBundle\Form\Type;


use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class ExtendedEntityType
 *
 * @see: https://github.com/symfony/symfony/issues/3836
 */
class ExtendedEntityType extends AbstractType
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     */
    function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);

        // Set choice_attributes on choices
        foreach ($view->vars['choices'] as $choice) {
            $additionalAttributes = array();
            foreach ($options['choice_attributes'] as $attributeName => $choicePath) {
                $additionalAttributes[$attributeName] = $this->propertyAccessor->getValue($choice->data, $choicePath);
            }

            $choice->attr = array_replace(isset($choice->attr) ? $choice->attr : array(), $additionalAttributes);
        }

        // Set choice_attributes on children (for example options, radio, etc)
        if ($options['expanded']) {
            foreach ($view as $i => $childView) {
                $additionalAttributes = array();
                foreach ($options['choice_attributes'] as $attributeName => $choicePath) {
                    $entity = $view->vars['choices'][$i]->data;
                    $additionalAttributes[$attributeName] = $this->propertyAccessor->getValue($entity, $choicePath);
                }

                $childView->vars['attr'] = array_replace(isset($childView->attr) ? $childView->attr : array(), $additionalAttributes);
            }
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(
            array(
                'choice_attributes' => array(),
            )
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'extended_entity';
    }
}
