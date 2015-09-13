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
use DN\TMBundle\Entity\Location;
use DN\TMBundle\Entity\Comment;

class CommentController extends Controller {

    /**
     * @Route("/save_comment_ajax/", name="save_comment_ajax")
     */
    public function saveAjaxAction(Request $request) {
        $content = $request->get('c');
        $type = $request->get('et');
        $slug = $request->get('es');

        $session = $request->getSession();
        $session->start();

        $loggedIdUser = $session->get('loggedInUser');

        // todo: checks
        $success = false;
        $content = '';
        $messages = array();
        if ($loggedIdUser == null) {
            $messages[] = array(
                'type' => 'error',
                'text' => 'not logged in',
            );
        } else {
            $object = new Comment();
            $object->setEntityType($type);
            $object->setEntitySlug($slug);
            $object->setUser($loggedIdUser);
            $object->setContent($content);
            $object->setCreated(new \DateTime('now'));

            $this->getDoctrine()->getManager()->merge($object);
            $this->getDoctrine()->getManager()->flush();

            $success = true;
            $content = $this->render('DNTMBundle:Course:comment.html.twig', array('c' => $object));
            $messages[] = array(
                'type' => 'success',
                'text' => 'sikeres komment',
            );
        }

        $retParams = array(
            'success' => $success,
            'messages' => $messages,
            'content' => $content,
        );

        return new Response(json_encode($retParams));
    }

}
