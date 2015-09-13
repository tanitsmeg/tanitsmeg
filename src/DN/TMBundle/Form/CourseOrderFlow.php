<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;
use Craue\FormFlowBundle\Form\FormFlow;

class CourseOrderFlow extends FormFlow {

    /**
     * @var FormTypeInterface
     */
    protected $formType;

    public function setFormType(FormTypeInterface $formType) {
        $this->formType = $formType;
    }

    public function getName() {
        return 'course_order';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'times',
                'type' => $this->formType,
            ),
            array(
                'label' => 'details',
                'type' => $this->formType,
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
            return $estimatedCurrentStepNumber > 1 && !$flow->getFormData()->canHaveEngine();
        },
            ),
            array(
                'label' => 'confirmation',
            ),
        );
    }

}
