<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Agenda\Contact;
use App\Form\AgendaBundlerType;
use App\Entity\Agenda\Phone;

final class ContactController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine, RequestStack $requestStack)
    {
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
    }


    public function show(Request $request): Response
    {
        $session = $request->getSession();
        if ($session) {
            $session->set('last_visited_section', 'contacts');
        } else {
            return $this->redirect($this->requestStack->getCurrentRequest()->headers->get('referer', $this->generateUrl('index')));
        }

        $session->remove('usuario_id');

        // flash (mensaje temporal).
        $this->addFlash('success', 'Contacto guardado correctamente');

        // Denegar acceso a usuarios no autenticados.
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $manager = $this->doctrine->getManager();
        //Consulta y objeto sobre contacto.  
        $contacts = $manager->getRepository(Contact::class);

        $contactQuery = $contacts->createQueryBuilder('c')
            ->select('c')
            ->where('c.user = :user')
            ->setParameter('user', $this->getUser())
            ->getQuery()->getResult();

        return $this->render('contact/showContacts.html.twig', [
            'contacts' => $contactQuery,
        ]);
    }

    public function new(Request $request)
    {

        $session = $request->getSession();
        if ($session) {
            $session->set('last_visited_section', 'contacts');
        } else {
            return $this->redirect($this->requestStack->getCurrentRequest()->headers->get('referer', $this->generateUrl('index')));
        }

        $session->remove('usuario_id');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $manager = $this->doctrine->getManager();

        $contactRepository = new Contact();
        $form = $this->createForm(AgendaBundlerType::class, $contactRepository, array(
            'action' => $this->generateUrl('contact_new'),
            'method' => 'POST'
        ));

        $contactRepository->setUser($this->getUser());


        $form->handleRequest($request);

        //Si el form es válido y se subió correctamente...
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($contactRepository); //Agregar información en la memoria del Manager.
            $manager->flush(); // Procesar actualización o inserciones de datos.

            //Retornar a la ruta principal si es correcto todo.
            return $this->redirectToRoute('contact_show');
        }
        return $this->render('contact\new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ContactController',
        ]);
    }

    public function edit(Request $request)
    {

        $session = $request->getSession();
        if ($session) {
            $session->set('last_visited_section', 'contacts');
        } else {
            return $this->redirect($this->requestStack->getCurrentRequest()->headers->get('referer', $this->generateUrl('index')));
        }

        $session->remove('usuario_id');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $manager = $this->doctrine->getManager();

        //Consulta de CONTACTO Buscando por Id.
        $contact = $manager->getRepository(Contact::class)->find($request->get('id'));

        //Creación de Formulario para Editar (es el mismo Formulario de Creación).
        //Pasar el Objeto $contactoRepository que contiene la info  del contacto a editar. 
        $form = $this->createForm(AgendaBundlerType::class, $contact, array());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Agregar el Entitymanager y enviar los datos a insertar. 
            $manager->persist($contact);
            $manager->flush();
            //Redirigir a la vista que quieras en caso que sea exitoso
            return $this->redirectToRoute('contact_show');
        }
        return $this->render('contact\editContact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request)
    {
        $session = $request->getSession();
        if ($session) {
            $session->set('last_visited_section', 'contacts');
        } else {
            return $this->redirect($this->requestStack->getCurrentRequest()->headers->get('referer', $this->generateUrl('index')));
        }

        $session->remove('usuario_id');
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $manager = $this->doctrine->getManager();
        $contact = $manager->getRepository(Contact::class)->find($request->get('id'));
        if ($contact) {
            $manager->remove($contact);
            $manager->flush();

            /*             $phone = $manager->getRepository(Phone::class)->find($request->get('id'));
             if ($phone) {
                $manager->remove($phone);
                $manager->flush();
            } */
        }
        return $this->redirectToRoute('contact_show');
    }
}
