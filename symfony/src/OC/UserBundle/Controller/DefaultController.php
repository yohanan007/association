<?php

namespace OC\UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use OC\UserBundle\Entity\User;
use OC\UserBundle\Form\UserType;
use OC\UserBundle\Form\User1Type;
use OC\UserBundle\Form\User2Type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        return $this->render('@OCUser/Default/index.html.twig');
    }
    
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(User2Type::class,$user);
        
        return $this->render('@OCUser/Default/register.html.twig',array('form'=>$form->createView()));
    }
    
    public function modificationAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
        return $this->render('@OCUser/Default/modification.html.twig',array('user'=>$user));
    }
    
    
    // page administrateur
    public function suppressionAction(Request $request)
    {
        if (!empty($request->query->get('id'))&&($request->query->get('id')!==null))
        {
        $id = $request->query->get('id');
        $userManager  = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
       $userManager->deleteUser($user);
        return new JsonResponse(array('reponse'=>'entité effacé'));
        }
       
    }
    
    // page administrateur information et confirmation utilisateur
    public function informationAction($id)
    {
       if(!empty($id)&&($id!==null))
       {
           $userManager = $this->get('fos_user.user_manager');
           $user = $userManager->findUserBy(array('id'=>$id));
           if(($user !== null)&&(!empty($user)))
           {
               return $this->render('@OCUser/Default/informationAdministrateur.html.twig',array('user'=>$user));
           }
           else {
               throw $this->createNotFoundException("l'utilisateur avec id:".$id."n'existe pas ");
           }
       }
    }
    
    // page     administrateur
    public function modificationUserAction(Request $request, $id)
    {
        if(!empty($id)&&($id !== null))
        {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserBy(array('id'=>$id));
            if($user === null)
            {
                return $this->createNotFoundException("l'utilisateur n'exite pas");
            }
            $form = $this->createForm(UserType::class,$user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $user = $form->getData();
                $userManager->updateUser($user);
             return $this->render('@OCUser/Default/modificationUser.html.twig',array('user'=>$user,'form'=>$form->createView()));
            }
            return $this->render('@OCUser/Default/modificationUser.html.twig',array('user'=>$user,'form'=>$form->createView()));
        }
        
    }
    
    // page administrateur
    public function administrateurAction()
    {
         $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('@OCUser/Default/administrateur.html.twig',array('users'=>$users));
    }
    
    //page administrateur
    public function activeAction(Request $request)
    {
        $id = $request->query->get('id');
        $active = $request->query->get('active');
        $userManager = $this->get('fos_user.user_manager');
        if ($id !== null){
             $user = $userManager->findUserBy(array('id'=>$id));
                    if ($user !== null )
                    {
                        if($active === 'true')
                        {
                            $user->setEnabled(false);
                            $userManager->updateUser($user);
                            return new JsonResponse(array('response'=>'update false ok'));
                        }
                        elseif($active === 'false')
                        {
                            $user->setEnabled(true);
                            $userManager->updateUser($user);
                            return new JsonResponse(array('response'=>'update true ok'));
                        }
                        else{
                            return $this->createNotFoundException("problême au niveau de active");
                        }
                    }
                    else {
                        return $this->createNotFoundException("utilisateur n'existe pas ");
                    }
        }else {
            return $this->createNotFoundException("id null ");
        }
       
        
    }
    
    
    // page administrateur
    public function roleAction(Request $request)
    {
        if(empty($request->query->get('id')))
        {
            return $this->createNotFoundException('problême request');
        }
        $id = $request->query->get('id');
        if($id === null || empty($id))
        {
            return $this->createNotFoundException("l'id fournit est de valeur null");
        }
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
                    if($user === null)
                    {
                       return $this->createNotFoundException("l'utilisateur avec id:".$id."n'existe pas ");
                    }
        $roles = $user->getRoles();
       
      
    
        if (in_array('ROLE_SUPER_ADMIN',$roles))
        {
           $user->removeRole('ROLE_SUPER_ADMIN');
               $user->removeRole('ROLE_ADMIN');
        }
        elseif(in_array('ROLE_ADMIN',$roles))
            {
                $user->addRole('ROLE_SUPER_ADMIN');
            }
            elseif(in_array('ROLE_USER',$roles))
            {
                $user->addRole('ROLE_ADMIN');
            }else{
                  
               return $this->createNotFoundException("problême inconnu de rôle");
            }
            $userManager->updateUser($user);
        return new JsonResponse(array('response'=>'le role à bien été modifié'));
    }
    
    
    public function mot_de_passeAction(Request $request,$id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
        if($user === null)
        {
            return $this->createNotFoundException("l'utilisateur avec id: ".$id."n'existe pas ");
        }
        $form = $this->createForm(User1Type::class,$user);
        return $this->render('@OCUser/Default/mot_de_passe.html.twig',array('user'=>$user,'form'=>$form->createView()));
    }
    
}