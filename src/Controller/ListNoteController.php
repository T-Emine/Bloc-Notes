<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Formulaire;
use App\Entity\Categorie;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ListNoteController extends Controller
{
    /**
     * @Route("/listNote", name="listNote")
     */
    public function index()
    {

        $note = $this->getDoctrine()
        ->getRepository(Formulaire::class)
        ->findAll();
        
        $cat = $this->getDoctrine()
        ->getRepository(Categorie::class)
        ->findAll();

        if (!$note) {
            throw $this->createNotFoundException(
                'No product found' 
            );
        }

        if (!$cat) {
            throw $this->createNotFoundException(
                'No product found' 
            );
        }

        return $this->render('listNote.html.twig', array('listNote' => $note, 'listCat'=>$cat));

    }


    /**
     * @Route("/deleteNote", name="deleteNote")
     */
    public function deleteNote(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Formulaire::class)->find($id);
        try {
            $entityManager->remove($em);
            $entityManager->flush();
        }catch (\Exception $ex){
            throw $this->createNotFoundException(
                'No product found' 
            );
        }
        return $this->redirectToRoute('listNote');
    }
    
    
    /**
     * @Route("/updateNote", name="updateNote")
     */
    public function updateNote(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Formulaire::class)->find($id);        
        $formulaire = $this->createFormBuilder($em)
        ->add('titre',TextType::class,array('label'=>'Titre'))  
        ->add('contenu',TextType::class,array('label'=>'Contenu'))
        ->add('date',DateType::class,array('label'=>'Date'))  
        ->add('categorie',EntityType::class,array('class' => Categorie::class,
                                                  'choice_label' => 'libelle',))
        ->add('bt_sauvegarde',SubmitType::class,array('label'=>'Sauvegarder'))  
        ->getForm();

        $formulaire->handleRequest ($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('listNote');
        }

        return $this->render('base.html.twig',array('forms'=>$formulaire->createView())) ;     
                
    }
	
	
}
