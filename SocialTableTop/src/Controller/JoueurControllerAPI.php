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

//class that does what joueurcontroller does but as an API
class JoueurControllerAPI extends AbstractController
{
    /**
     * @Route("/API/joueur/{id}", name="joueurapi", methods={"GET"})
     */
    public function joueurApi(Request $request, $id)
    {

        $encoders = array( new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
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
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

     /**
     * @Route("/API/joueurs", name="joueursapi", methods={"GET"})
     */
    public function joueursApi(Request $request)
    {
        $encoders = array( new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $joueurs = $this->getDoctrine()
            ->getRepository(Joueur::class)
            ->findAll(); 
        $jsonContent = $serializer->serialize($joueurs,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    
    
  /**
     * @Route("/API/newjoueur", name="newjoueurAPI", methods={"POST", "OPTIONS"})
     */
    public function saveJoueurAPI(Request $request)
    {
        $response = new Response();
        $query = array();
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
            return $response;
        }
        $json = $request->getContent();
        $content = json_decode($json, true);
        if (isset($content["name"]))
        {
            $joueur = new Joueur();
            $joueur->setTitle($content["name"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            
            $query['valid'] = true; 
            $query['data'] = array('name' => $content["name"]);
            $response->setStatusCode('201');
        }
        else 
        {
            $query['valid'] = false; 
            $query['data'] = null;
            $response->setStatusCode('404');
        }        
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));
        return $response;
    }
  

     
    /**
     * @Route("/API/updatejoueur/{id}", name="updatejoueurAPI", methods={"PUT", "OPTIONS"})
     */
    public function updatejoueurAPI(Request $request, $id)
    {
        $response = new Response();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
            return $response;
        }
        $json = $request->getContent();
        $content = json_decode($json, true);
        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        
        if (isset($content["name"])){

            $joueur->setName($content["name"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            $encoders = array( new JsonEncoder());
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(1);
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($joueur,'json');
            $response->setContent($jsonContent);
        }

        else{
            $encoders = array( new JsonEncoder());
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(1);
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);
            $text = "error, you did not send the right json, json must have: name";
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response; 
    }

    /**
     * @Route("/API/deletejoueur/{id}", name="apideletejoueur", methods={"DELETE", "OPTIONS"})
     */
    public function deleteJoueurAPI(Request $request, $id)
    {
        $response = new Response();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
            return $response;
        }

        $joueur = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($joueur);
        $em->flush();
        $encoders = array( new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
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
