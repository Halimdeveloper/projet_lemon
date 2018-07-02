<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class UserController extends Controller
{

/**
 * @Route("/index", name="index")
 * 
 */
    public function addAction(Request $request)
    {
        //on crée un utilisateur
        $user = new User();

        //on récupère le formulaire
        $form = $this->createForm(UserType::class, $user);

        //on gère la soumission
        $form->handleRequest($request);

        //si le formulaire a été soumis
        if ($form->isSubmitted() && $form->isValid()) {

            //on enregistre l'utilisateur dans la BDD
            $em = $this->getDoctrine()->getManager();   
            $em->persist($user);
            $em->flush();

            //on envoie un email récapitulatif à l'utilisateur et à l'admin
            


            //on retourne une réponse
            return new Response("Utilisateur ajouté dans la base de données.
             Vous devriez recevoir un mail de confirmation d'ici quelques minutes.");
        }

        //on génère le html du formulaire créé
        $formView = $form->createView();

        //on rend la vue
        return $this->render('userAdd.html.twig', array('form'=>$formView));
    }

}