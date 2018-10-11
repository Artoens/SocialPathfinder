<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FullDisplayController extends AbstractController
{
    /**
     * @Route("/", name="full_display")
     */
    public function index()
    {
        $colors = array("red", "green", "blue", "yellow"); 
        $result = "<ul>";

        foreach ($colors as $value) {
            $result .= "<li>".$value."<\li>";
        }

        $result .= "</ul>";
        return $this->render('full_display/index.html.twig', [
            'data' => $result,
        ]);
    }
}
