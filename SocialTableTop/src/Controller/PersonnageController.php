<?php

namespace App\Controller;
use App\Entity\Personnage;
use App\Entity\Joueur;
use App\Entity\MyTable;
use App\Form\PersonnageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonnageController extends AbstractController
{
    /**
     * @Route("/newpersonnage", name="newpersonnage")
     */
    public function savePersonngage(Request $request)
    {
        $table = new Personnage();
        
        $form = $this->createForm(PersonnageType::class, $table);

        $form->handleRequest($request);

        $table = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
            $em->flush();
            return new Response('Le Personnage est ajoutée avec succès !'); 
        }

        return $this->render('personnage/new.html.twig', array('form' =>$form->createView())); 
    }
    /**
     * @Route("/personnage", name="personnage")
     */
    public function index()
    {
        return $this->render('personnage/index.html.twig', [
            'controller_name' => 'PersonnageController',
        ]);
    }

}
