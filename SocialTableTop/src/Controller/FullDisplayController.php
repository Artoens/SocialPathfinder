<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Joueur;
use App\Entity\Personnage;
use App\Entity\Table;

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
                    ->find(1);
        echo $pers->getTableDeJeux()->GetName();
        // $tables = $this->getDoctrine()
        //     ->getRepository(Table::class)
        //     ->findAll();

        
        return $this->render('full_display/index.html.twig', [
            'joueurs' => $joueurs,
            'pers' => $pers,
            // 'tables' => $tables
        ]);
    }
}
