<?php
// src/Blogger/BlogBundle/Controller/CommentController.php

namespace Blogger\BlogBundle\Controller\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Comment;
use Blogger\BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
/*
 public function getRequest()
{
    return $this->container->get('request_stack')->getCurrentRequest();
}
*/
   
   public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);
        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(CommentType::class, $comment);
        return $this->render('@BloggerBlog/Plantilla/Comment/form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/blog/comment/{blog_id}", name="comment", requirements={"id"="\d+"})
    */
    public function createAction($blog_id, Request $request)
    {
        $blog = $this->getBlog($blog_id);
        $comment  = new Comment();
        $comment->setBlog($blog);
       // $request = $this->getRequest();
        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('show', array(
                'id' => $comment->getBlog()->getId())) .
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('@BloggerBlog/Plantilla/Comment/create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
                    ->getManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}