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
     * @Route("/API/newjoueur", name="newjoueurAPI", methods={"POST"})
     */
    public function saveJoueurAPI(Request $request)
    {
        $json = $request->getContent();
        $content = json_decode($json, true);
        $joueur = new Joueur();
        $response = new JsonResponse();
        
        if (isset($content["name"])){

            $joueur->setName($content["name"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
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
            $text = "created";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }

        else{
            $encoders = array( new JsonEncoder());
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(2);
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);
            $text = "error YOU DUMASS";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response; 
    }    

     
    /**
     * @Route("/API/updatejoueur/{id}", name="updatejoueurAPI", methods={"PUT"})
     */
    public function updatejoueurAPI(Request $request, $id)
    {
        $json = $request->getContent();
        $content = json_decode($json, true);
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        $response = new JsonResponse();
        
        if (isset($content["name"])){

            $joueur->setName($content["name"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
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
            $text = "updated";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }

        else{
            $encoders = array( new JsonEncoder());
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(2);
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);
            $text = "error YOU DUMASS";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response; 
    }

    /**
     * @Route("/api/deletejoueur/{id}", name="apideletejoueur", methods={"DELETE"})
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
