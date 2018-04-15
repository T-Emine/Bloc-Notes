<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Categorie;
use App\Entity\catulaire;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RESTCatController extends Controller
{
    /**
     * @Route("/api/cat/get", name="REST_GET_CAT")
     */
    public function REST_get()
    {

        $em = $this -> getDoctrine() -> getRepository (Categorie::class)->findall();
        $encoder = array(new JsonEncoder());
        $normalizers= array(new ObjectNormalizer());
        $serializer = new Serializer ($normalizers,$encoder);

        $data =  $serializer->serialize($em, 'json');
        
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
        
        $response->setContent($data);

        return $response;

    }

    /**
     * @Route("/api/cat/post", name="REST_POST_CATzzz")
     * @Method("POST")
     */
    public function REST_post(Request $request)
    {
        $content = $request->getContent();
        $elem = json_decode($content, true);
        $cat = new Categorie();
        $cat->setLibelle($elem['libelle']);

        $em=$this->getDoctrine()->getManager();
 
        try{
            $em->persist($cat);
            $em->flush();
        }catch(\Exception $ex){
            return new Response('Erreur post');
        }
        return $this->redirectToRoute('listCat');
   }


   /**
     * @Route("/api/cat/put", name="REST_PUT_CAT")
     * @Method("PUT")
     */
    public function REST_put(Request $request)
    {
        $content = $request->getContent();
        $elem = json_decode($content, true);

        if (isset($elem ['id'])){

            try{
                $cat = $this->getDoctrine()
                ->getRepository(Categorie::class)
                ->find($elem['id']);
            }catch(\Exception $ex){
                return new Response('Erreur put recherche id');
            }

            if($cat != null){
                if (isset($elem ['libelle'])){
                    $cat->setLibelle($elem['libelle']);
                }
                $em=$this->getDoctrine()->getManager();
    
                try{
                    $em->flush();
                }catch(\Exception $ex){
                    return new Response('Erreur post');
                }
                return $this->redirectToRoute('listCat');
            }else{
                return new Response(' ID non existant');
            }
        }
    }

    /**
     * @Route("/api/cat/delete", name="REST_DELETE_CAT")
     * @Method("DELETE")
     */
    public function REST_delete(Request $request)
    {
        $content = $request->getContent();
        $elem = json_decode($content, true);

        if (isset($elem ['id'])){
            try{
                $cat = $this->getDoctrine()
                ->getRepository(Categorie::class)
                ->find($elem['id']);
            }catch(\Exception $ex){
                return new Response('Erreur put recherche id');
            }

            if($cat != null){
                $em = $this->getDoctrine()->getManager();
                try{
                    $em->remove($cat);
                    $em->flush();
                }catch(\Exception $ex){
                    return new Response('Erreur delete');
                }
                return $this->redirectToRoute('listCat');
            }
        }else{
            return new Response(' ID non existant');
        }
    }
}