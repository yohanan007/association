<?php

namespace OC\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use OC\BlogBundle\Form\Image_transferType;
use OC\BlogBundle\Service\FileUploader;
use OC\BlogBundle\Entity\Image_transfer;

use OC\GestionBundle\Entity\Image;
use OC\GestionBundle\Entity\Article;
use OC\GestionBundle\Entity\Section;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
   
    public function indexAction()
    {
        //test branch 2
        return $this->render('@OCBlog/Default/index.html.twig');
    }
    
    public function blogAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Section::class);
        $section = $repository->findJoinSection($id);
        
        return $this->render('@OCBlog/Default/blog.html.twig',array('section'=>$section));
    }
    
    public function acceuilAction()
    {
        $repository = $this->getDoctrine()->getRepository(Section::class);
        $section = $repository->findAll();
        return $this->render('@OCBlog/Default/acceuil.html.twig', array('section'=>$section));
    }
    
    public function imageAction(Request $request)
    {
        
        $fileUploader = $this->get(FileUploader::class);
        $image = new Image_transfer();
        //$image->setImage(new File($this->getParameter('image_directory').'/'.$image->getImage()));
        $form = $this->createForm(Image_transferType::class, $image);
        $form->handleRequest($request);
        
        
        // à adapter
          if ($form->isSubmitted() && $form->isValid()) {
              $em = $this->getDoctrine()->getManager();
        $file = $image->getImage();
        $fileName = $fileUploader->upload($file);

        $image->setImage($fileName);
        $em->persist($image);
        $em->flush();
        return $this->redirect($this->generateUrl('oc_blog_homepage'));
            }
        return $this->render('@OCBlog/Default/image.html.twig',array('form'=>$form->createView()));
        
    }
    
    public function bibliothequeAction()
    {
        $em = $this->getDoctrine()->getRepository(Image_transfer::class);
        $image = $em->findAll();
        return $this->render('@OCBlog/Default/bibliotheque.html.twig', array('image'=>$image));
    }
}
