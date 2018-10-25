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
        $joueurs = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->findAll();

        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
            'joueurs' => $joueurs
        ]);
    }

    /**
     * @Route("/joueur/{id}", name="joueur")
     */
    public function viewjoeur($id)
    {
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);


        return $this->render('joueur/view.html.twig', [
            'controller_name' => 'PersonnageController',
            'joueur' => $joueur,
        ]);
    }

    
    /**
     * @Route("/updatejoueur/{id}", name="updatejoueur")
     */
    public function updatejoueur(Request $request, $id)
    {
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        
        $form = $this->createForm(JoueurType::class, $joueur);

        $form->handleRequest($request);

        $joueur = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            return new Response('Le joueur est changé avec succès !'); 
        }

        return $this->render('personnage/new.html.twig', array('form' =>$form->createView())); 
    }

    /**
     * @Route("/deletejoueur/{id}", name="deletejoueur")
     */
    public function deletePersonngage(Request $request, $id)
    {
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($joueur);
        $em->flush();

        return $this->redirect($this->generateUrl('full_display'));
    }
} 
