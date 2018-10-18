<?php

namespace OC\AuthBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use OC\AuthBundle\Form\evenementType;
use OC\AuthBundle\Form\PresentType;
use OC\AuthBundle\Form\UserEditType;
use OC\AuthBundle\Entity\evenement;
use OC\AuthBundle\Entity\Present;
use OC\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    // controller concernnat gestion des événements
    
    // controlle l'index du bundle ( sommaire création événements, gestion événements , ajout de participant, etc...)
    public function indexAction()
    {
        return $this->render('@OCAuth/Default/index.html.twig');
    }
    
    // controlle le formulaire de création d'un événement 
    public function creerAction(Request $request)
    {
        $evenement =  new evenement();
        $form = $this->createForm(evenementType::class,$evenement);
        $form->handleRequest($request);
        if(($form->isSubmitted())&&($form->isValid()))
        {
         $evenement = $form->getData();
         $em = $this->getDoctrine()->getManager();
         $em->persist($evenement);
         $em->flush();
                //création des jours dans entité Present
        if(($evenement->getType()) === 'jour')
            {
                
                $dateDebut = $evenement->getDateDebut();
                $dateFin = $evenement->getDateFin();
                $i = $dateDebut;
                while($i <= $dateFin)
                {   
                    $present = new Present();
                    $present->setEvenement($evenement);
                    $present->setJour($i);
                    $em->persist($present);
                    $em->flush();
                    $i->modify('+ 1 day');
                }
                
            }
         return $this->redirectToRoute('oc_auth_homepage');
        }
        return $this->render('@OCAuth/Default/creer.html.twig',array('form'=>$form->createView()));
    }
    
    public function inscriptionJourAction(Request $request,$id)
    {
        $present = new Present();
        $user = new User();
        
        $em = $this->getDoctrine()->getRepository(evenement::class);
        $form = $this->createForm(UserEditType::class,$user,['userID'=>$id]);
        $form->handleRequest($request);
        $evenementfind = $em->find(array('id'=>$id));
        if (($form->isSubmitted())&&($form->isValid()))
        {
            $user = $form->getData();
            $em1 = $this->getDoctrine()->getManager();
            
            $presents = $form->get('presents')->getData();
            foreach($presents as $present)
            {
           $user->addPresent($present);
            
            $em1->persist($user);
            
            $em1->flush();
            }
            return $this->redirectToRoute('oc_auth_homepage');
        }
        return $this->render('@OCAuth/Default/inscriptionJour.html.twig',array('evenement'=>$evenementfind,'form'=>$form->createView()));
    }
    
    public function modificationMenuAction()
    {
        $em = $this->getDoctrine()->getRepository(evenement::class);
        $evenement = $em->findAll();
        return $this->render('@OCAuth/Default/modificationMenu.html.twig',array('evenement'=>$evenement));
    }
    
    public function modificationAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getRepository(evenement::class);
        $evenement = $em->findEvenement($id);
        
        return $this->render('@OCAuth/Default/modification.html.twig',array('id'=>$id,'evenement'=>$evenement));
    }
    
    // action de supression d'un événement
    public function suppressionAction(Request $request)
    {
        if (empty($request->query->get('id'))||(null===$request->query->get('id')))
        {
            return $this->redirectToRoute('oc_blog_index');
        }
        else{
            $id = $request->query->get('id');
           
            $em3 = $this->getDoctrine()->getRepository(evenement::class);
            $evenement = $em3->find($id);
            $em2 = $this->getDoctrine()->getManager();
            
            $em2->remove($evenement);
            $em2->flush();
            
       
            return new JsonResponse(array('message'=>'evenement supprimé'));
        }
    }
    
 // controller concernant confirmation inscription en fonction de la journée
        public function confirmationJourneeAction(Request $request, $id)
        {
            $present = new Present();
            $journee = new Present();
            $emJournee = $this->getDoctrine()->getRepository(Present::class);
            $journee = $emJournee->find($id);
            $form = $this->createForm(PresentType::class,$present,['jourID'=>$id]);
            $form->handleRequest($request);
            if($form->isValid()&&$form->isSubmitted())
            {
                    $emPersist = $this->getDoctrine()->getManager();
                    $data = $form->getData();
                    $emPersist->persist($data);
                    $emPersist->flush();
                return $this->redirectToRoute('oc_auth_homepage');                
            }
            return $this->render('@OCAuth/Default/confirmationJournee.html.twig',array('form'=>$form->createView()));
        }
        
// controller concernant confirmant inscritpion en fonction de l'utilisateur
        public function confirmationUtilisateurAction(Request $request, $id)
        {
            
        }

}
