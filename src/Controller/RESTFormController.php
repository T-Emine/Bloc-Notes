<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Categorie;
use App\Entity\Formulaire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use \DateTime;
 
class RESTFormController extends Controller
{
    /**
     * Fonction GET
     * @Route("/api/form/get", name="REST_GET_FORM")
     * @Method({"GET","OPTIONS"})
     */
    public function REST_get(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

        }else{
            
            $em = $this -> getDoctrine() -> getRepository (Formulaire::class)->findall();     
            $data = $this->get('serializer')->serialize($em, 'json');
            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");            
            $response->setContent($data);
        }
            return $response;

    }

    /**
     * Fonction POST
     * @Route("/api/form/post", name="REST_POST_FORM")
     * @Method({"POST","OPTIONS"})
     */
    public function REST_post(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

            return $response;

        }else{
            $content = $request->getContent();
            $elem = json_decode($content, true);
            $form = new Formulaire();
            $date = new DateTime($elem['date']);
            $form->setdate($date);
            $form->setTitre($elem['titre']);
            $form->setContenu($elem['contenu']);

            $cat = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->find($elem['categorie_id']);

            $form->setCategorie($cat);

            $em=$this->getDoctrine()->getManager();
    
            try{
                $em->persist($form);
                $em->flush();
            }catch(\Exception $ex){
                return new Response('Erreur post');
            }
        }
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

        return $response;        
   }
    

    /**
     * Fonction PUT
     * @Route("/api/form/put", name="REST_PUT_FORM")
     * @Method({"PUT","OPTIONS"})
     */
    public function REST_put(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

            return $response;

        }else{

            $content = $request->getContent();
            $elem = json_decode($content, true);

            if (isset($elem ['id'])){

                try{
                    $form = $this->getDoctrine()
                    ->getRepository(Formulaire::class)
                    ->find($elem['id']);
                }catch(\Exception $ex){
                    return new Response('Erreur put recherche id');
                }

                if($form != null){
                    if (isset($elem ['date'])){
                        $date = new DateTime($elem['date']);
                        $form->setdate($date);
                    }
                    if (isset($elem ['titre'])){    
                        $form->setTitre($elem['titre']);
                    }
                    if (isset($elem ['contenu'])){
                        $form->setContenu($elem['contenu']);
                    }
                    
                    if (isset($elem ['categorie_id'])){
                        $cat = $this->getDoctrine()
                        ->getRepository(Categorie::class)
                        ->find($elem['categorie_id']);//c'est l'id
                
                        $form->setCategorie($cat);
                    }
                    $em=$this->getDoctrine()->getManager();
        
                    try{
                        $em->flush();
                    }catch(\Exception $ex){
                        return new Response('Erreur post');
                    }
                }else{
                    return new Response('ID non existant');
                }
            }
        }
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

    }

    /**
     * Fonction DELETE
     * @Route("/api/form/delete/{id}", name="REST_DELETE_FORM")
     * @Method({"DELETE","OPTIONS"})
     */
    public function REST_delete(Request $request, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
            return $response;

        }else{
            
            if (isset($id)){
                try{
                    $form = $this->getDoctrine()
                    ->getRepository(Formulaire::class)
                    ->find($id);
                }catch(\Exception $ex){
                    return new Response('Erreur put recherche id');
                }

                if($form != null){
                    $em = $this->getDoctrine()->getManager();
                    try{
                        $em->remove($form);
                        $em->flush();
                    }catch(\Exception $ex){
                        return new Response('Erreur delete');
                    }
                    return $this->redirectToRoute('note');
                }
            }else{
                return new Response('ID non existant');
            }
        }
    }

    /**
     * Fonction pour récupérer une note via son id
     * @Route("/api/form/getID/{id}", name="REST_GET_FORMID")
     * @Method({"GET","OPTIONS"})
     */
    public function REST_getID(Request $request, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

        }else{
            $em = $this -> getDoctrine() -> getRepository (Formulaire::class) -> find($id);

            $encoder = array(new JsonEncoder());
            $normalizers= array(new ObjectNormalizer());
            $serializer = new Serializer ($normalizers,$encoder);

            $data =  $serializer->serialize($em, 'json');
            
            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            
            $response->setContent($data);
        }

        return $response;
    }
    
}



