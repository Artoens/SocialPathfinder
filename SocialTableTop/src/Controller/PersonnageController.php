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
        $perso = new Personnage();
        
        $form = $this->createForm(PersonnageType::class, $perso);

        $form->handleRequest($request);

        $perso = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($perso);
            $em->flush();
            $this->addFlash('notice', 'Personnage créé!');
            return $this->redirect($this->generateUrl('persos'));
        }

        return $this->render('personnage/new.html.twig', array('form' =>$form->createView())); 
    }

    /**
     * @Route("/updatepersonnage/{id}", name="updatepersonnage")
     */
    public function updatePersonngage(Request $request, $id)
    {
        $per = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->find($id);
        
        $form = $this->createForm(PersonnageType::class, $per);

        $form->handleRequest($request);

        $per = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($per);
            $em->flush();
            $this->addFlash('notice', 'Personnage mis à jour!');
            return $this->redirect($this->generateUrl('persos'));
        }

        return $this->render('personnage/new.html.twig', array('form' =>$form->createView())); 
    }

    /**
     * @Route("/deletepersonnage/{id}", name="deletepersonnage")
     */
    public function deletePersonngage(Request $request, $id)
    {
        $per = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($per);
        $em->flush();
        $this->addFlash('notice', 'Personnage supprimée!');
        return $this->redirect($this->generateUrl('persos'));
    }
} 