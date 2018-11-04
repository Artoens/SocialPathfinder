<?php

namespace App\Controller;

use App\Form\JoueurType;
use App\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JoueurControllerAPI extends AbstractController
{
    /**
     * @Route("/API/joueur/{id}", name="joueurapi", methods={"GET"})
     */
    public function joueurApi(Request $request, $id)
    {

        $encoders = array( new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        $jsonContent = $serializer->serialize($joueur,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }
    
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
            $this->addFlash('notice', 'Joueur créé!');
            return $this->redirect($this->generateUrl('full_display')); 
        }

        return $this->render('joueur/new.html.twig', array('form' =>$form->createView())); 
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
            $this->addFlash('notice', 'Joueur Mis à jour!');
            return $this->redirect($this->generateUrl('full_display'));  
        }

        return $this->render('joueur/new.html.twig', array('form' =>$form->createView()));
    }

    /**
     * @Route("/api/deletejoueur/{id}", name="apideletejoueur")
     */
    public function deleteJoueurAPI(Request $request, $id)
    {
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($joueur);
        $em->flush();
        $encoders = array( new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $text = "deleted";
        $jsonContent = $serializer->serialize($text,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }
} 
