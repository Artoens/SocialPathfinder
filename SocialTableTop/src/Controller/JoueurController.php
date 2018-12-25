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
     * show one specific player
     * @Route("/joueur/{id}", name="joueur")
     */
    public function joueur(Request $request, $id)
    {
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);

        return $this->render('joueur/index.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    /**
     * create a new player
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
            $this->addFlash('notice', 'Joueur créé!');
            return $this->redirect($this->generateUrl('full_display')); 
        }

        return $this->render('joueur/new.html.twig', array('form' =>$form->createView())); 
    }    
     
    /**
     * update a player
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
            $this->addFlash('notice', 'Joueur Mis à jour!');
            return $this->redirect($this->generateUrl('full_display'));  
        }

        return $this->render('joueur/new.html.twig', array('form' =>$form->createView()));
    }

    /**
     * delete a player
     * @Route("/deletejoueur/{id}", name="deletejoueur")
     */
    public function deleteJoueur(Request $request, $id)
    {
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($joueur);
        $em->flush();
        $this->addFlash('notice', 'Joueur supprimée!');
        return $this->redirect($this->generateUrl('full_display'));
    }
} 
