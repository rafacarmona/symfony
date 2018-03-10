<?php 

namespace Blogger\BlogBundle\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller{

    /**
    * @Route("/blog/{id}", name="show", requirements={"id"="\d+"})
    */
    public function showAction($id){

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        $comment = $em->getRepository('BloggerBlogBundle:Comment')-> getCommentsForBlog($id);
        if(!$blog){
            throw $this->createNotFoundException('Unabled to find Blog post.');
        }

        return $this->render('@BloggerBlog/Blog/show.html.twig', 
            array('blog' => $blog, 'comments' => $comment));

    }
}

?>