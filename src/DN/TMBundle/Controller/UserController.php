<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\User;
use DN\TMBundle\Entity\Product;
use DN\TMBundle\Entity\Course;
use DN\TMBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller {

    /**
     * @Route("/signup/", name="user_signup")
     */
    public function signupAction(Request $request) {
        $object = new User();

        $form = $this->createForm('user_signup', $object);

        $form->handleRequest($request);
        $messages = array();

        if ($form->isValid()) {
            $formData = $form->getData();
//            if ($formData->getPassword() != $formData->getPassword2()) {
//                $messages[] = 'user_signup_different_passwords';
//            } else {
                $filters = array(
                    'email' => $formData->getEmail(),
                );
                $existingUser = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->findOneBy($filters);

                if (!$existingUser) {
                    $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->saveUser($form->getData());
                    $messages[] = 'user_signup_success';
                } else {
                    $messages[] = 'user_signup_email_exists';
                }
//            }
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'form' => $form->createView(),
            'messages' => $messages,
        );

        return $this->render('DNTMBundle:User:user_signup.html.twig', $retParams);
    }

    /**
     * @Route("/teacher_signup/", name="teacher_signup")
     */
    public function teacherSignupAction(Request $request) {
        $object = new User();

        $form = $this->createForm('teacher_signup', $object);

        $form->handleRequest($request);
        $messages = array();

        if ($form->isValid()) {
            $formData = $form->getData();
//            if ($formData->getPassword() != $formData->getPassword2()) {
//                $messages[] = 'user_signup_different_passwords';
//            } else {
                $filters = array(
                    'email' => $formData->getEmail(),
                );
                $existingUser = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->findOneBy($filters);

                if (!$existingUser) {
                    $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->saveTeacher($form->getData());
                    $messages[] = 'teacher_signup_success';
                } else {
                    $messages[] = 'teacher_signup_email_exists';
                }
//            }
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'form' => $form->createView(),
            'messages' => $messages,
        );

        return $this->render('DNTMBundle:User:teacher_signup.html.twig', $retParams);
    }

    /**
     * @Route("/login/", name="user_login")
     */
    public function loginAction(Request $request) {
        $object = new User();

        $form = $this->createForm('user_login', $object);

        $messages = array();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $filters = array(
                'email' => $object->getEmail(),
                'password' => $object->getPassword(),
            );

            $user = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->findOneBy($filters);

            if ($user != null) {
                $session = $request->getSession();
                $session->start();
                $session->set('loggedInUser', $user);

                return new RedirectResponse($this->generateUrl('course_list'));
            } else {
                $messages[] = 'user_login_wrong_data';
            }
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'form' => $form->createView(),
            'messages' => $messages,
        );

        return $this->render('DNTMBundle:User:user_login.html.twig', $retParams);
    }

    /**
     * @Route("/logout/", name="user_logout")
     */
    public function logoutAction(Request $request) {
        $session = $request->getSession();
        $session->start();

        $loggedIdUser = $session->get('loggedInUser');
        if ($loggedIdUser) {
            $session->remove('loggedInUser');
        }
        return new RedirectResponse($this->generateUrl('course_list'));
    }

    /**
     * @Route("/user_signup_ajax/", name="user_signup_ajax")
     */
    public function signupAjaxAction(Request $request) {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        $filters = array(
            'name' => $name,
            'email' => $email,
        );

        $user = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->findBy($filters);

        $messages = array();
        if ($user != null) {
            $messages[] = array(
                'type' => 'error',
                'text' => 'foglalt email vagy név',
            );
        } else {
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->merge($user);
            $this->getDoctrine()->getManager()->flush();

            $messages[] = array(
                'type' => 'message',
                'text' => 'sikeres regisztráció',
            );
        }

        $retParams = array(
            'messages' => $messages,
        );

        return new Response(json_encode($retParams));
    }

    /**
     * @Route("/userprofile/{slug}/", name="user_profile")
     */
    public function userProfileAction(Request $request) {
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
     * @Route("/user/{slug}/", defaults={"slug" = null}, name="user_view")
     */
    public function viewAction($slug) {
        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->findOneBy(array('slug' => $slug));

        if ($object == null) {
            throw $this->createNotFoundException("no users to display");
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
        );

        return $this->render('DNTMBundle:User:view.html.twig', $retParams);
    }

    /**
     * @Route("/user/{slug}/edit/", defaults={"slug" = null}, name="user_edit")
     */
    public function editAction(Request $request, $slug) {
        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->findOneBy(array('slug' => $slug));

        $form = $this->createForm('user_data', $object);

        $form->handleRequest($request);
        $messages = array();

        $session = $request->getSession();
        $session->start();
        $loggedInUser = $session->get('loggedInUser');

        if ($loggedInUser == null) {
            throw $this->createNotFoundException("not logged in");
        }

        if ($object == null) {
            throw $this->createNotFoundException("no users with this url");
        }

        if ($loggedInUser->getId() != $object->getId()) {
            throw $this->createNotFoundException("not allowed to edit");
        }

        if ($form->isValid()) {
            $formSaveSuccess = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:User')->saveUserData($form->getData());
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'form' => $form->createView(),
            'messages' => $messages,
        );

        return $this->render('DNTMBundle:User:edit.html.twig', $retParams);
    }

}
