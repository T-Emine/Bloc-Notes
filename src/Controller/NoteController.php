<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formulaire;
use App\Entity\Categorie;

class NoteController extends Controller
{
    /* INUTILE

    public function index()
    {
        return $this->render('note  /index.html.twig', [
            'controller_name' => 'NoteController',
        ]);
    }
*/
    /**
     * @Route("/note", name="note")
     */
    public function new(Request $request) //GERE L ENVOI ET LA RECUPERATION DE DONNEES EN MEME TEMPS
    {
        // creates a task and gives it some dummy data for this example
        $task = new Formulaire();
       

        $formulaire = $this->createFormBuilder($task)
            ->add('titre', TextType::class, array('label' => 'Titre'))
            ->add('contenu', TextType::class, array('label' => 'Contenu'))
            ->add('date', DateType::class, array('label' => 'Date'))
            ->add('categorie', EntityType::class, array('class' => Categorie::class,
                                                        'choice_label' => 'libelle',))
            ->add('bt_sauvegarde', SubmitType::class, array('label' => 'Sauvegarder'))
            ->getForm(); 

            $formulaire->handleRequest($request);
            $task = $formulaire->getData();
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return new Response('La tâche ajoutée avec succès !'); }
        return $this->render('base.html.twig', array('forms' => $formulaire->createView()));
    }
/* CELUI CI EST GERER EN HAUT.
    public function createAction(){
                
        $firstTest = $this->getDoctrine()->getManager();
        $ft = new Formulaire();
        $ft->setTitre("Le premier titre")
           ->setDate(new \DateTime())
           ->setCategorie("TestCat")
           ->setContenu("Je test pour la première fois la db et je met du texte à la bourin !")
        ;        
        $firstTest->persist($ft);
        $firstTest->flush();

        return $this->render('base.html.twig', array());
        //le prof fais cette méthode un peu differemment
    }
*/
/*
    
    public function showAction(){
        $em = $this->getDoctrine()->getManager();
        $formulaire = $em->getRepository("Formulaire:Formulaire")->findAll();
        return $this->render('base.html.twig', array('formulaire' => $formulaire,));
    }
*/
}

