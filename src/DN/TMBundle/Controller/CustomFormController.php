<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CustomFormController extends Controller {

    /**
     * @Route("/business/online-anfragen/", defaults={"formType" = "contact"}, name="custom_form_contact")
     * @Route("/custom-form/post/{formType}/", defaults={"formType" = null}, name="custom_form_post")
     */
    public function viewAction($formType, Request $request) {
        $form = $this->createForm($formType);

        $form->handleRequest($request);

        $responseMessage = null;
        if ($form->isValid()) {
            $formSaveSuccess = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomFormData')->saveForm($form->getData(), $formType);

            if ($formSaveSuccess) {
                $responseMessage = 'Form sent successfully! Danke!';
            }
        } 
        
        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'form' => $form->createView(),
            'formType' => $formType,
            'responseMessage' => $responseMessage,
        );

        return $this->render('DNTMBundle:Form:' . $formType . '.html.twig', $retParams);
    }

    /**
     * @Route("/form-success/{formType}/", defaults={"formType" = null}, name="custom_form_success")
     */
    public function successAction($formType, Request $request) {
        $form = $this->createForm($formType);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formSaveSuccess = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomFormData')->saveForm($form->getData(), $formType);
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'form' => $form->createView(),
            'formType' => $formType,
        );

        return $this->render('DNTMBundle:Form:' . $formType . '.html.twig', $retParams);
    }

}
