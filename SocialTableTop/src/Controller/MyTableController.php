<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\MyTable;
use App\Form\MyTableType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MyTableController extends AbstractController
{
    /**
     * @Route("/newtable", name="newtable")
     */
    public function savetable(Request $request)
    {
        $table = new MyTable();
        
        $form = $this->createForm(MyTableType::class, $table);

        $form->handleRequest($request);

        $table = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
            $em->flush();
            return new Response('La table est ajoutée avec succès !'); 
        }

        return $this->render('my_table/new.html.twig', array('form' =>$form->createView())); 
    }
    /**
     * @Route("/mytable", name="mytable")
     */
    public function index()
    {
        return $this->render('my_table/index.html.twig', [
            'controller_name' => 'MyTableController',
        ]);
    }
}
