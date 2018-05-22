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

    /**
     * Création d'une formulaire (bloc-note)
     * @Route("/note", name="note")
     */
    public function new(Request $request) //GERE L ENVOI ET LA RECUPERATION DE DONNEES EN MEME TEMPS
    {
        $task = new Formulaire();

        $formulaire = $this->createFormBuilder($task)
            ->add('titre', TextType::class, array('label' => 'Titre'))
            ->add('contenu' , TextType::class, array('label' => 'Contenu'))
            ->add('date', DateType::class, array('label' => 'Date'))
            ->add('categorie', EntityType::class, array('class' => Categorie::class,
                                                        'choice_label' => 'libelle',))
            ->add('bt_sauvegarde', SubmitType::class, array('label' => 'Sauvegarder'))
            ->getForm(); 


            $formulaire->handleRequest($request);
            $task = $formulaire->getData();
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $xmlText = '<?xml version="1.0" encoding="UTF-8"?> ';
            $xmlText .= '        <contenu>';
            $xmlText .= $task->getContenu() ;
            $xmlText .='        </contenu>';

            $task->setContenu($xmlText);
            $em->persist($task);
            $em->flush();

            return new Response('La tâche est ajoutée avec succès !'); }
            $a = $this->render('base.html.twig', array('forms' => $formulaire->createView()));
            
        return $a;
    }


}

