<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\Table;
use App\Form\TableType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TableController extends AbstractController
{
    /**
     * @Route("/newtable", name="newtable")
     */
    public function savetable(Request $request)
    {
        $table = new Table();
        
        $form = $this->createForm(TableType::class, $table);

        $form->handleRequest($request);

        $table = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
            $em->flush();
            return new Response('La table est ajoutée avec succès !'); 
        }

        return $this->render('table/new.html.twig', array('form' =>$form->createView())); 
    }
    /**
     * @Route("/table", name="table")
     */
    public function index()
    {
        return $this->render('table/index.html.twig', [
            'controller_name' => 'TableController',
        ]);
    }
}
