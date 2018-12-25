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
     * acces a specific table
     * @Route("/table/{id}", name="table")
     */
    public function Mytable(Request $request, $id)
    {
        $table = $this->getDoctrine()
                    ->getRepository(Mytable::class)
                    ->find($id);

        return $this->render('my_table/index.html.twig', [
            'table' => $table,
        ]);
    }
    
    /**
     * create a new table
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
            $this->addFlash('notice', 'Table créé!');
            return $this->redirect($this->generateUrl('tables'));  
        }

        return $this->render('my_table/new.html.twig', array('form' =>$form->createView())); 
    }
    
    /**
     * update a table
     * @Route("/updatemytable/{id}", name="updatemytable")
     */
    public function updatePersonngage(Request $request, $id)
    {
        $table = $this->getDoctrine()
                    ->getRepository(Mytable::class)
                    ->find($id);
        
        $form = $this->createForm(MyTableType::class, $table);

        $form->handleRequest($request);

        $table = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
            $em->flush();
            $this->addFlash('notice', 'Table mise à jour!');
            return $this->redirect($this->generateUrl('tables'));  
        }

        return $this->render('my_table/new.html.twig', array('form' =>$form->createView())); 
    }

    /**
     * delete a table
     * @Route("/deletemytable/{id}", name="deletemytable")
     */
    public function deletePersonngage(Request $request, $id)
    {
        $table = $this->getDoctrine()
                    ->getRepository(MyTable::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($table);
        $em->flush();
        $this->addFlash('notice', 'Table supprimée!');
        return $this->redirect($this->generateUrl('tables'));
    }
}
