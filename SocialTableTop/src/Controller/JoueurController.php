<?php

namespace App\Controller;

use App\Form\JoueurType;
use App\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JoueurController extends AbstractController
{
    /**
     * @Route("/newjoueur", name="newjoueur")
     */
    public function saveJoueur(Request $request)
    {
        $joueur = new Joueur();
        
        $form = $this->createForm(JoueurType::class, $joueur);

        $form->handleRequest($request);

        $joueur = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            return new Response('Le Personnage est ajoutée avec succès !'); 
        }

        return $this->render('joueur/new.html.twig', array('form' =>$form->createView())); 
    }
    
    /**
     * @Route("/joueur", name="joueur")
     */
    public function index()
    {
        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
        ]);
    }
}
