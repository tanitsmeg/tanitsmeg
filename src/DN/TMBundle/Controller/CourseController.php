<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\Product;
use DN\TMBundle\Entity\Course;
use DN\TMBundle\Entity\Category;
use DN\TMBundle\Form\Type\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use DN\TMBundle\Entity\Location;
use DN\TMBundle\Entity\Image;

class CourseController extends Controller {

    /**
     * @Route("/course/{slug}/", defaults={"slug" = null}, name="course_view")
     */
    public function viewAction(Request $request, $slug) {
        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->findOneBy(array('slug' => $slug));

        if ($object == null) {
            throw $this->createNotFoundException("no courses to display");
        }

        $comments = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Comment')->getComments('course', $slug);

        $jsParams = array(
            'saveCommentAjaxUrl' => $this->generateUrl('save_comment_ajax'),
            'entitySlug' => $object->getSlug(),
            'entityType' => 'course',
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'comments' => $comments,
        );

        return $this->render('DNTMBundle:Course:view.html.twig', $retParams);
    }

    /**
     * @Route("/course/{slug}/edit/", defaults={"slug" = null}, name="course_edit")
     */
    public function editAction(Request $request, $slug) {
        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->findOneBy(array('slug' => $slug));

        if ($object == null) {
            throw $this->createNotFoundException("no courses to display");
        }

        $form = $this->container->get('form.factory')
                ->createNamed(
                '', 'course'
        );

        $formSaveSuccess = false;
        $form->handleRequest($request);

        if ($form->isValid()) {
//            $formSaveSuccess = $this->em->getRepository('TDBFIBundle:CustomFormData')->saveForm($form->getData(), 'Education program');
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'form' => $form->createView(),
        );

        return $this->render('DNTMBundle:Course:edit.html.twig', $retParams);
    }

    /**
     * @Route("/course/{slug}/order/", defaults={"slug" = null}, name="course_order")
     */
    public function orderAction(Request $request, $slug) {
        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->findOneBy(array('slug' => $slug));

        if ($object == null) {
            throw $this->createNotFoundException("no courses to display");
        }

        $form = $this->container->get('form.factory')
                ->createNamed(
                '', 'course_order'
        );

        $formSaveSuccess = false;
        $form->handleRequest($request);

        if ($form->isValid()) {
            $formSaveSuccess = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CourseOrder')->saveForm($form->getData());
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'form' => $form->createView(),
        );

        return $this->render('DNTMBundle:Course:order.html.twig', $retParams);
    }

    /**
     * @Route("/coursecreate/", name="course_create")
     */
    public function createAction(Request $request) {
        $object = new Course();

        $form = $this->createForm('course', $object);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $objectPersisted = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->saveForm($form->getData());

            if ($objectPersisted) {
                return new RedirectResponse($this->generateUrl('course_view', array('slug' => $objectPersisted->getSlug())));
            }
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'form' => $form->createView(),
        );

        return $this->render('DNTMBundle:Course:edit.html.twig', $retParams);
    }

    /**
     * @Route("/", name="course_list")
     */
    public function listAction(Request $request) {
        $filters = array();

        if ($request->get('tag') != null) {
            $tags = explode(' ', $request->get('tag'));
            $filters['tags'] = $tags;
        } else {
            $tags = [];
            $filters['tags'] = null;
        }

        if ($request->get('param') != null) {
            $params = explode(' ', $request->get('param'));
            $filters['params'] = $params;
        } else {
            $params = [];
            $filters['params'] = null;
        }

        if ($request->get('q') != null) {
            $filters['text'] = $request->get('q');
        } else {
            $filters['text'] = null;
        }

        $objectList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->getCoursesByFilters($filters);
        $tagList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Tag')->findAll();

        $filterParamTitles = array(
            'pets' => 'Kutyabarát',
            'wheelchair' => 'Akadálymentesített',
            'earlybird' => 'Early Birds kedvezmény',
            'group' => 'Csoportos kedvezmény',
        );

        $jsParams = array(
            'courseListAjaxPath' => $this->generateUrl('course_list_ajax'),
            'filters' => $filters,
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'filters' => $filters,
            'tagList' => $tagList,
            'filterParamTitles' => $filterParamTitles,
            'objectList' => $objectList,
        );

        return $this->render('DNTMBundle:Course:list.html.twig', $retParams);
    }

    /**
     * @Route("/courselist_ajax/", name="course_list_ajax")
     */
    public function listAjaxAction(Request $request) {
        $filters = $request->get('filters');

        $objectList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->getCoursesByFilters($filters);

        $retParams = array(
            'objectList' => $objectList,
        );

        return $this->render('DNTMBundle:Course:list_results.html.twig', $retParams);
    }

}
