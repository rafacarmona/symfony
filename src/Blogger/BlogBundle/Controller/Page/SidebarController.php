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
class SidebarController extends Controller
{
  public function sidebarAction()
  {
    $em = $this->getDoctrine()
               ->getManager();
    $tags = $em->getRepository('BloggerBlogBundle:Blog')
               ->getTags();
    $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
                  ->getTagWeights($tags);
    $commentLimit   = $this->container
                       ->getParameter('blogger_blog.comments.latest_comment_limit');
    $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
                      ->getLatestComments($commentLimit);

    return $this->render('@BloggerBlog/Plantilla/sidebar.html.twig', array(
    'tags'              => $tagWeights,
    'latestComments'    => $latestComments

    ));
  }

}