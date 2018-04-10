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
     * @Route("/api/form/get", name="REST_GET_FORM")
     * @Method("GET")
     */
    public function REST_get(Request $request)
    {

            $em = $this -> getDoctrine() -> getRepository (Formulaire::class)->findall();
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
     * @Route("/api/form/post", name="REST_POST_FORM")
     * @Method("POST")
     */
    public function REST_post(Request $request)
    {
        $content = $request->getContent();
        $elem = json_decode($content, true);
        $form = new Formulaire();
        $date = new DateTime($elem['date']);
        $form->setdate($date);
        $form->setTitre($elem['titre']);
        $form->setContenu($elem['contenu']);

        $cat = $this->getDoctrine()
        ->getRepository(Categorie::class)
        ->find($elem['categorie']);

        $form->setCategorie($cat);

        $em=$this->getDoctrine()->getManager();
 
        try{
            $em->persist($form);
            $em->flush();
        }catch(\Exception $ex){
            return new Response('Erreur post');
        }
        return $this->redirectToRoute('note');
   }
    

    /**
     * @Route("/api/form/put", name="REST_PUT_FORM")
     * @Method("PUT")
     */
    public function REST_put(Request $request)
    {
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
                    $id = $form->setdate($date);
                    $form->setdate($date);
                }
                if (isset($elem ['titre'])){
                    $form->setTitre($elem['titre']);
                }
                if (isset($elem ['contenu'])){
                    $form->setContenu($elem['contenu']);
                }
                if (isset($elem ['categorie'])){
                    $cat = $this->getDoctrine()
                    ->getRepository(Categorie::class)
                    ->find($elem['categorie']);
            
                    $form->setCategorie($cat);
                }
                $em=$this->getDoctrine()->getManager();
    
                try{
                    //$em->persist($form);
                    $em->flush();
                }catch(\Exception $ex){
                    return new Response('Erreur post');
                }
                return $this->redirectToRoute('note');
            }else{
                return new Response(' ID non existant');
            }
        }
    }

    /**
     * @Route("/api/form/delete", name="REST_DELETE_FORM")
     * @Method("DELETE")
     */
    public function REST_delete(Request $request)
    {
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
            return new Response(' ID non existant');
        }
    }
    
}



