<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use src\Entity\Formulaire;

class LuckyController extends Controller
{
	/**
	*@Route("/HEY")
	*/
    public function number()
    {
      $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: </body></html>'
        );
    }

    /**
	*@Route("/HEY2")
	*/
    public function helloAction()
    {
        $name = 'Welcome to NotePad v 0.0!';

          return $this->render('base.html.twig', array('name' => $name));
    }

}



?>