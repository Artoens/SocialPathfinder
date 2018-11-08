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
     * @Route("/api/presonnage/{id}", name="personnageapi", methods={"GET"})
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
        return $response;
    }

    /**
     * @Route("/api/newpersonnage", name="newpersonnageapi", methods={"POST"})
     */
    public function savePersonngageAPI(Request $request)
    {
        $json = $request->getContent();
        $content = json_decode($json, true);
        $perso = new Personnage();
        $response = new JsonResponse();
        
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
            $encoders = array( new JsonEncoder());
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(1);
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);
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
            $text = "error, you did not send the right json, json must have: name, idjoueur and idtable";
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response;
    }

    /**
     * @Route("/api/updatepersonnage/{id}", name="updatepersonnageapi", methods={"PUT"})
     */
    public function updatePersonngageAPI(Request $request, $id)
    {
        $json = $request->getContent();
        $content = json_decode($json, true);
        $perso = $this->getDoctrine()
                    ->getRepository(Personnage::class)
                    ->find($id);
        $response = new JsonResponse();
        
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
            $jsonContent = $serializer->serialize($text,'json');
            $response->setContent($jsonContent);
        }
        return $response;
    }

    /**
     * @Route("/api/deletepersonnage/{id}", name="deletepersonnageapi", methods={"DELETE"})
     */
    public function deletePersonngageAPI(Request $request, $id)
    {
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