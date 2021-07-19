<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Project;
use App\Form\EquipeType;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe")
     */
    public function index(): Response
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }
    /**
     * @Route("/ajoutequipe", name="ajoutequipe")
     */
    public function ajoutequipe(Request $req)
    {
        $equipe= new  Equipe() ;
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('equipe');
        }
        return $this->render('equipe/ajout.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/liste", name="liste")
     */
    public function liste(Request $req)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $equipes= $entityManager->getRepository(Equipe::class)->findAll();
        return $this->render('equipe/liste.html.twig', array('equipes' => $equipes));
    }
}
