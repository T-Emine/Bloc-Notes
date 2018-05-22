<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Categorie;


class CategorieController extends Controller
{
    /**
     * Création d'une catégorie
     * @Route("/categorie", name="categorie")
     */
    public function index(Request $request)
    {
        $task = new Categorie();

        $cat_forms = $this->createFormBuilder($task)
               ->add('libelle', TextType::class, array('label' => 'Categorie'))
               ->add('bt_ajout', SubmitType::class, array('label' => 'Sauvegarder'))
               ->getForm(); 

        $cat_forms->handleRequest($request);
        $task = $cat_forms->getData();
        if ($cat_forms->isSubmitted() && $cat_forms->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return new Response('La catégorie est ajoutée avec succès !'); }

    return $this->render('categorie.html.twig', array('cat' => $cat_forms->createView()));
    }
}       