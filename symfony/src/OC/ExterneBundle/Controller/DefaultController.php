<?php

namespace OC\ExterneBundle\Controller;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OC\BlogBundle\Entity\Image_transfer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    
    // controller renvoyant les adresses des  images à une application externe 
    public function indexAction(Request $request)
    {
        if(!empty($request->get('user'))&&!empty($request->get('mdp')))
        {
            $user = $request->get('user');
            $mdp = $request->get('mdp');
            $userManager = $this->get('fos_user.user_manager');
            $result = $userManager->findUserBy(array('username'=>$user));
            $encoder_service = $this->get('security.encoder_factory');
           $encoder = $encoder_service->getEncoder($result);
            if($encoder->isPasswordValid($result->getPassword(), $mdp, $result->getSalt()))
            {
                $em = $this->getDoctrine()->getRepository(Image_transfer::class);
                $images = $em->findAll();
                $tab = array(array('id'=>'..','adresse'=>'..'));
                foreach($images as $image)
                {
                    $id = $image->getId();
                    $adresse = $image->getImage();
                    $tab2 = array('id'=>$id,'adresse'=>$adresse);
                    array_push($tab,$tab2);
                }
                return new JsonResponse(json_encode($tab));
            }
        }
          return $this->redirectToRoute('oc_blog_homepage');
             
    }
    
    // controller authentification des user à partir d'une application externe à symfony 
    public function userAction(Request $request)
    {
        if(!empty($request->get('user'))&&(!empty($request->get('mdp'))))
        {
           $user = $request->get('user');
           $mdp = $request->get('mdp');
           
           $userManager = $this->get('fos_user.user_manager');
           // encode password
           
           $result = $userManager->findUserBy(array('username'=>$user));
          // on cherche le service encode password et on verifie si le password est bon 
           $encoder_service = $this->get('security.encoder_factory');
           $encoder = $encoder_service->getEncoder($result);
           if($encoder->isPasswordValid($result->getPassword(), $mdp, $result->getSalt()))
           {
               // on ne peut envoyer directement l'entité qui n'est pas sous forme de tableau, on doit donc serializer l'entity
               // ou envoyer sous forme 'manuel' et json 
            return new JsonResponse(array('user'=>$result->getUsername(),'authentification'=>'ok'));
           }
           else {
               return new JsonResponse(array('authentification'=>'no'));
           }
        }
        
       return $this->render('@OCBlog/Default/transfer.html.twig');
    }

            // reception Image 
    public function receptionAction(Request $request, $user , $idUser, $mdpUser)
    {
         $userManager = $this->get('fos_user.user_manager');
           // encode password
           
           $result = $userManager->findUserBy(array('id'=>$idUser,'username'=>$user));
            $encoder_service = $this->get('security.encoder_factory');
           $encoder = $encoder_service->getEncoder($result);
           if($encoder->isPasswordValid($result->getPassword(), $mdpUser, $result->getSalt()))
           {
               $file = new File($request->files('ionicFile'));
               //suite...
               
           }
        
    }
}
