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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PersonnageControllerAPI extends AbstractController
{
    /**
     * @Route("/API/personnage/{id}", name="personnageapi", methods={"GET"})
     */
    public function personnageAPI(Request $request, $id)
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
        $personnage = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->find($id);
        $jsonContent = $serializer->serialize($personnage,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

      /**
     * @Route("/API/presonnages", name="personnagesapi", methods={"GET"})
     */
    
    public function personnagesAPI(Request $request)
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
        $personnage = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->findAll(); 
        $jsonContent = $serializer->serialize($personnage,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/API/newpersonnage", name="newpersonnageapi", methods={"POST", "OPTIONS"})
     */
    public function savePersonngageAPI(Request $request)
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
        $perso = new Personnage();
        
        if (isset($content["name"]) && isset($content["idjoueur"])&& isset($content["idtable"])){

            $perso->setName($content["name"]);
            $j = $this->getDoctrine()
                ->getRepository(Joueur::class)
                ->find($content["idjoueur"]);
            $perso->setJoueur($j);
            $t = $this->getDoctrine()
                ->getRepository(MyTable::class)
                ->find($content["idtable"]);
            $perso->setTableDeJeux($t);
            $em = $this->getDoctrine()->getManager();
            $em->persist($perso);
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
     * @Route("/API/updatepersonnage/{id}", name="updatepersonnageapi", methods={"PUT", "OPTIONS"})
     */
    public function updatePersonngageAPI(Request $request, $id)
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
        $perso = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->find($id);
     
        
        if (isset($content["name"]) || isset($content["idjoueur"])|| isset($content["idtable"])){
            if(isset($content["name"])){
                $perso->setName($content["name"]);
            }
            if(isset($content["idjoueur"])){
            $j = $this->getDoctrine()
                ->getRepository(Joueur::class)
                ->find($content["idjoueur"]);
            $perso->setJoueur($j);
            }
            if(isset($content["idtable"])){
            $t = $this->getDoctrine()
                ->getRepository(MyTable::class)
                ->find($content["idtable"]);
            $perso->setTableDeJeux($t);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($perso);
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
            $jsonContent = $serializer->serialize($perso,'json');
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
            $text = "error, you did not send the right json, json must have: name or idjoueur or idtable or a combination of those";
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response;
    }

    /**
     * @Route("/API/deletepersonnage/{id}", name="deletepersonnageapi", methods={"DELETE", "OPTIONS"})
     */
    public function deletePersonngageAPI(Request $request, $id)
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

        $per = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($per);
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