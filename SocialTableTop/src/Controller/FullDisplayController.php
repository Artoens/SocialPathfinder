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

        $joueurs = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->findAll(); 
        
        $pers = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->findall();
        $tables = $this->getDoctrine()
             ->getRepository(MyTable::class)
             ->findAll();

        
        return $this->render('full_display/index.html.twig', [
            'joueurs' => $joueurs,
            'pers' => $pers,
            'tables' => $tables
        ]);
    }
}
