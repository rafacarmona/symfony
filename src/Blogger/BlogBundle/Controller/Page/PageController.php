<?php

namespace Blogger\BlogBundle\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//Use para enviar correo
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Blogger\BlogBundle\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Request;


class PageController extends Controller {
	/**
	 * @Route("/blog", name="blog")
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();
     	$blogs = $em->getRepository('BloggerBlogBundle:Blog')->getLatestBlog();
     	if(!$blogs){
      		throw $this->createNotFoundException("Unable to find Blog post.");
     	}
        return $this->render('@BloggerBlog/Plantilla/index.html.twig', array("blogs" => $blogs));
	}

	/**
	 * @Route("/blog/about", name="about")
	 */
	public function aboutAction() {
		return $this->render('@BloggerBlog/Plantilla/about.html.twig');
	}

	/**
	 * @Route("/blog/contact", name="contact")
	 */
	public function contactAction(Request $request) {
		//Para enviar un correo
    	$enquiry = new Enquiry();
    	$form = $this->createForm(EnquiryType::class, $enquiry);
    	$form->handleRequest($request);

		if($form->isSubmitted()){
			if($form -> isValid()){
				$message = \Swift_Message::newInstance()
						->setSubject('Contact enquiry from symblog')
						->setFrom('sabioiesgc@gmail.com')
						->setTo('rafacarmona97@gmail.com')
						->setBody($this->renderVIew('@BloggerBlog/Plantilla/contactEmail.txt.twig',
							array('enquiry'=>$enquiry)));
				$this->get('mailer')->send($message);
			}

			// $this->addFlash('notice', 'Mensaje enviado');
			// return $this->redirectToRoute('home');
		}
		return $this->render('@BloggerBlog/Plantilla/contact.html.twig', array('form' => $form->createVIew()));
	}

}
