<?php

namespace App\Controller;

use App\Entity\Classroom;
use Doctrine\Persistence\ManagerRegistry;

use App\Form\ClassroommType;
use App\Repository\ClassroomRepository;
#use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);

    }
    #[Route('/listClassroom', name: 'listClassroom')]
    public function listClassroom(ClassroomRepository  $repository)
    {
        $Classroom= $repository->findAll();
        return $this->render("Classroom/list.html.twig",array("tabClassroom"=>$Classroom));
    }
    #[Route('/addClassroomForm', name: 'addClassroomForm')]
    public function addClassroomForm(Request  $request,ManagerRegistry $doctrine)
    {
        $Classroom= new  Classroom();
        $form= $this->createForm(ClassroommType::class,$Classroom);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($Classroom);
            $em->flush();
            return  $this->redirectToRoute("addClassroomForm");
        }
        return $this->renderForm("Classroom/add.html.twig",array("FormClassroom"=>$form));
    }





    #[Route('/updateClassroom/{nce}', name: 'update_Classroom')]
    public function updateClassroomForm($nce,ClassroomRepository  $repository,Request  $request,ManagerRegistry $doctrine)
    {
        $Classroom= $repository->find($nce);
        $form= $this->createForm(ClassroommType::class,$Classroom);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("addClassroomForm");
        }
        return $this->renderForm("Classroom/update.html.twig",array("FormClassroom"=>$form));
    }
    #[Route('/removeClassroom/{nce}', name: 'remove_Classroom')]
    public function remove(ManagerRegistry $doctrine,$nce,ClassroomRepository $repository)
    {
        $Classroom= $repository->find($nce);
        $em= $doctrine->getManager();
        $em->remove($Classroom);
        $em->flush();
        return $this->redirectToRoute("addClassroomForm");
    }

}
