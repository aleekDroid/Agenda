<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Agenda\Contact;
use App\Form\AgendaBundlerType;

final class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_index")
  
     *public function index(): Response
     *{
     *    return $this->render('contact/index.html.twig', [
     
     *'controller_name' => 'ContactController',
     *   ]);
     *}
     */

    public function new(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(AgendaBundlerType::class, $contact, array(
            'action' => $this->generateUrl('contact_new'),
            'method' => 'POST'
        ));

        return $this->render('contact\new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ContactController',
        ]);
    }

    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
}
