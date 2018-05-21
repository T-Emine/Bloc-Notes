<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Formulaire;
use App\Entity\Categorie;
use App\Entity\RechercheTAG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;


class ListNoteController extends Controller
{
    /**
     * @Route("/listNote", name="listNote")
     */
    public function index(Request $request )
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

        $task = new RechercheTAG();
        $tabNote = array();
        $tabCat = array();

        $formulaire = $this->createFormBuilder($task)
            ->add('tag', TextType::class, array('label' => ' '))
            ->add('bt_search', SubmitType::class, array('label' => 'Search'))
            ->getForm(); 

            $formulaire->handleRequest($request);
            $task = $formulaire->getData();
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $note = " ";
                $em = $this->getDoctrine()->getManager();
                $tab = $this->searchTag($task->gettag());
                foreach($tab as $t) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $em = $entityManager-> getRepository (Formulaire::class)->find($t);  
                    $em2 = $entityManager-> getRepository (Categorie::class)->find($em->getCategorie());  

                    array_push($tabNote, $em);
                    array_push($tabCat, $em2);

                }
                return $this->render('listNote.html.twig', array('listNote' => $tabNote, 'listCat'=>$tabCat,'search'=>$formulaire->createView()));
            }else{
                return $this->render('listNote.html.twig', array('listNote' => $note, 'listCat'=>$cat,'search'=>$formulaire->createView()));

            }
    }
    

    /**
     * @Route("/searchTAG", name="searchTAG")
     */
    
    public function searchTag(String $leTag){

        $tab = array();
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Formulaire::class)->findAll();

        $z="Pas trouvé";
        
        foreach($em as $a) {   
            $c= $a->getContenu();
            $xml = new \DOMDocument('1.0', 'utf-8');

            $xml->loadXML($c);
            $livre = $xml->documentElement;

            $xpath = new \DOMXPath($xml);
            $tds = $xpath->query('//contenu/tag');
            foreach($tds as $b) {
                if($b->nodeValue == $leTag){
                    array_push($tab, $a->getId());
                }
            }        
        }

        return $tab; 
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
