<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\Personnage;
use App\Entity\MyTable;
use App\Form\MyTableType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class MyTableControllerAPI extends AbstractController
{
    /**
     * @Route("/api/table/{id}", name="tableAPI", methods={"GET"})
     */
    public function MytableAPI(Request $request, $id)
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
        $table = $this->getDoctrine()
                    ->getRepository(Mytable::class)
                    ->find($id);
        $jsonContent = $serializer->serialize($table,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }
    
    /**
     * @Route("/api/newtable", name="newtableAPI", methods={"POST"})
     */
    public function savetableAPI(Request $request)
    {
        $json = $request->getContent();
        $content = json_decode($json, true);
        $table = new MyTable();
        $response = new JsonResponse();
        
        if (isset($content["name"]) && isset($content["mj"]) && isset($content["description"]) && isset($content["idjoueurs"])){

            $table->setName($content["name"]);
            $table->setMJ($content["mj"]);
            $table->setDescription($content["description"]);
            foreach ($content["idjoueurs"] as $idj){
                $j = $this->getDoctrine()
                    ->getRepository(Joueur::class)
                    ->find($idj);
                $table->addJoueur($j);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
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
            $jsonContent = $serializer->serialize($table,'json');
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
            $text = "error, you did not send the right json, json must have: name, mj, description, idjoueur[id, id]";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response;
    }
    
    /**
     * @Route("/api/updatemytable/{id}", name="updatemytableapi", methods={"PUT"})
     */
    public function updatePersonngageAPI(Request $request, $id)
    {
        $json = $request->getContent();
        $content = json_decode($json, true);
        $table = $this->getDoctrine()
                    ->getRepository(Mytable::class)
                    ->find($id);
        $response = new JsonResponse();
        
        if (isset($content["name"]) || isset($content["mj"]) || isset($content["description"]) || isset($content["idjoueurs"]) || isset($content["idpersos"])){
            
            if (isset($content["name"])){
                $table->setName($content["name"]);
            }
            if (isset($content["mj"])){
                $table->setMJ($content["mj"]);
            }
            if(isset($content["description"])){
                $table->setDescription($content["description"]);
            }
            if(isset($content["idjoueurs"])){
                foreach ($content["idjoueurs"] as $idj){
                    $j = $this->getDoctrine()
                        ->getRepository(Joueur::class)
                        ->find($idj);
                    $table->addJoueur($j);                
                }
            }
            if (isset($content["idpersos"])){
                foreach ($content["idpersos"] as $idp){
                    $p = $this->getDoctrine()
                        ->getRepository(Personnage::class)
                        ->find($idp);
                    $table->addPersonnage($p);                
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
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
            $jsonContent = $serializer->serialize($table,'json');
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
            $text = "error, you did not send the right json, json must have:name or mj or description or id joueurs or idpersos or a combination of those";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response;
    }

    /**
     * @Route("/api/deletemytable/{id}", name="deletemytableapi", methods={"DELETE"})
     */
    public function deletePersonngageAPI(Request $request, $id)
    {
        $table = $this->getDoctrine()
                    ->getRepository(MyTable::class)
                    ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($table);
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
