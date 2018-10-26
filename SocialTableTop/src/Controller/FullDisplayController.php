<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Joueur;
use App\Entity\Personnage;
use App\Entity\MyTable;

class FullDisplayController extends AbstractController
{
    /**
     * @Route("/", name="full_display")
     */
    public function index()
    {        
        return $this->redirect($this->generateUrl('players'));
    }
    /**
     * @Route("/players", name="players")
     */
    public function players()
    {

        $joueurs = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->findAll(); 
        
        return $this->render('full_display/players.html.twig', [
            'joueurs' => $joueurs,
        ]);
    }
    /**
     * @Route("/tables", name="tables")
     */
    public function tables()
    {

        $tables = $this->getDoctrine()
                    ->getRepository(MyTable::class)
                    ->findAll(); 
        
        return $this->render('full_display/tables.html.twig', [
            'tables' => $tables,
        ]);
    }
     /**
     * @Route("/persos", name="persos")
     */
    public function Persos()
    {

        $persos = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->findAll(); 
        
        return $this->render('full_display/persos.html.twig', [
            'pers' => $persos,
        ]);
    }
}
