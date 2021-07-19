<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
    /**
     * @Route("/ajoutproject", name="ajoutproject")
     */
    public function ajoutproject(Request $req)
    {
        $project= new  Project() ;
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project');
        }
        return $this->render('project/ajout.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/supprime/{id}", name="supprime")
     */
    public function supprime(ProjectRepository $repository,$id)
    {

        $project=$repository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($project);
        $entityManager->flush();
        return $this->redirectToRoute('project');
    }
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $req,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project= $entityManager->getRepository(Project::class)->find($id);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project');
        }
        return $this->render('project/update.html.twig', array('form' => $form->createView()));
    }

}
