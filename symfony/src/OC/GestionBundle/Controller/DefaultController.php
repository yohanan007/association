<?php

namespace OC\GestionBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\GestionBundle\Form\ImageType;
use OC\GestionBundle\Form\ArticleType;
use OC\GestionBundle\Form\SectionType; 
use OC\GestionBundle\Entity\Image;
use OC\GestionBundle\Entity\Article;
use OC\GestionBundle\Entity\Section;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;

class DefaultController extends Controller
{
    // menu general 
    public function introAction()
    {
        return $this->render('@OCGestion/Default/menu.html.twig');
    }
    
    // création d'une page 
    public function indexAction(Request $request)
    {
       // création d'une nouvelle section puis redirection vers la création d'un article avec image
         $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
         if ($form->handleRequest($request))
        {
             if ($form->isSubmitted() && $form->isValid())
             {
                 $article = $form->getData();
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($section);
                 $em->flush();
                 $id = $section->getId();
                 
                 return $this->redirectToRoute('oc_gestion_articlepage',array('id'=>$id));
             }
        }
        return $this->render('@OCGestion/Default/index.html.twig', array('form'=>$form->createView()));
    }
    
    
    // création d'un article d'une page en fonction de l'id d'une page 
    public function articleAction(Request $request,$id)
    {
       
        $repository = $this->getDoctrine()->getRepository(Section::class);
        try{
        $section = $repository->find($id);
        }
        catch(Exception $e){
            return $this->redirectToRoute('oc_blog_homepage');
        }
        $article = new Article();
        $image = new Image();
        $form = $this->createForm(ArticleType::class, $article);
        if ($form->handleRequest($request))
        {
             if ($form->isSubmitted() && $form->isValid())
             {
                 $article = $form->getData();
                 $em = $this->getDoctrine()->getManager();
                  $article->setSection($section);
               
                 $imagesData= $form->get('images')->getData();
                 if ($imagesData[0] !== null)
                 {
                     $image = $imagesData[0];
                  $image->setArticle($article);
                  $em->persist($article);
                 $em->persist($image); 
                 }
                 else {
                     $em->persist($article);
                 }
                 $em->flush();
                 return $this->redirectToRoute('oc_blog_homepage');
             }
        }
        return $this->render('@OCGestion/Default/gestionArticle.html.twig', array('form'=>$form->createView(),'section'=>$section));
    }
    
    // menu general des section permettant de modifier une page 
    public function sectionMenuAction()
    {
        $em = $this->getDoctrine()->getRepository(Section::class);
        $section = $em->findAll();
        
        return $this->render('@OCGestion/Default/sectionMenu.html.twig', array('section'=>$section));
    }
    
    // modification d'une page en fonction de son id 
    public function sectionIdAction($id)
    {
        $em = $this->getDoctrine()->getRepository(Section::class);
        $section = $em->find($id);
        $form = $this->createForm(SectionType::class, $section); 
         return $this->render('@OCGestion/Default/sectionId.html.twig', array('section'=>$section,'form'=>$form->createView()));
    }

// page gestion menu  general article 
    public function articlePageAction(Request $request)
    {
     $em = $this->getDoctrine()->getRepository(Article::class);
        if ($request->request->get('article'))
        {
            $postArticle =  $request->request->get('Idarticle');
            $articleId = $em->find($postArticle);
            return new JsonResponse(array('id'=>$articleId->getId()));
        }
      $article = $em->findAll();
      return $this->render('@OCGestion/Default/articleMenu.html.twig', array('article'=>$article));
    }
    
    // controller permettant de modifier un article en fonction de son id 
    public function ModificationArticleIdAction($id)
    {   $em = $this->getDoctrine()->getRepository(Article::class);
        $article = $em->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        return $this->render('@OCGestion/Default/modificationArticle.html.twig', array('article'=>$article,'form'=> $form->createView()));
    }

    public function articleGetAction(Request $request)
    {
        if(!empty($request->get('data'))&& (null !== ($request->get('data'))))
                {
                    $data = $request->get('data');
                    $em = $this->getDoctrine()->getRepository(Article::class);
                    $article = $em -> findArticleByLetter($data);
                    $tab = array(array('id'=>'..', 'nom'=>'..', 'contenu'=>'..'));
                   foreach($article as $value)
                    {
                        $id = $value->getId();
                        $nom = $value->getNom();
                        $contenu = $value->getContenu();
                       $array2 = array('id'=>$id, 'nom'=>$nom, 'contenu'=>$contenu);
                array_push($tab, $array2);
                    }
                    return new JsonResponse(json_encode($tab));
                }  
                return $this->redirectToRoute('oc_blog_homepage');
    }
    
    public function testAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);
        return $this->render('@OCGestion/Default/test.html.twig',array('form'=>$form->createView()));
    }
}
