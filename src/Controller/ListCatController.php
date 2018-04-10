<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ListCatController extends Controller
{
    /**
     * @Route("/listCat", name="listCat")
     */
    public function index()
    {
        
        $ctg = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();
        
        if (!$ctg) {
            throw $this->createNotFoundException(
                'No product found' 
            );
        }

        //$().button('toggle')
        
        return $this->render('listCat.html.twig', array('listCat' => $ctg));
    }


    /**
     * @Route("/deleteCat", name="deleteCat")
     */
    public function deleteCat(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Categorie::class)->find($id);
        try {
            $entityManager->remove($em);
            $entityManager->flush();
        }catch (\Exception $ex){
            throw $this->createNotFoundException(
                'No product found' 
            );
        }
        return $this->redirectToRoute('listCat');
    }
    
    
    /**
     * @Route("/updateCat", name="updateCat")
     */
    public function updateCat(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Categorie::class)->find($id);        
        $cat_forms = $this->createFormBuilder($em)
               ->add('libelle', TextType::class, array('label' => 'Categorie'))
               ->add('bt_ajout', SubmitType::class, array('label' => 'Sauvegarder'))
               ->getForm(); 

        $cat_forms->handleRequest ($request);

        if ($cat_forms->isSubmitted() && $cat_forms->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('listCat');
        }

        return $this->render('categorie.html.twig',array('cat'=>$cat_forms->createView())) ;     
                
    }
}