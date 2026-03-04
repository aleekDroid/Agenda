<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Agenda;
use App\Form\AgendaType;

final class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact_new')]
    public function index(Request $request): Response
    {
        $agenda = new Agenda();
        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($agenda);
            $this->em->flush(); 
            return $this->redirectToRoute('index');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView() ,
        ]);
    }

}   