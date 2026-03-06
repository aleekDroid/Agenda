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

    public function show()
    {
        //Manager de Doctine (Base de datos).
        $manager = $this->doctrine->getManager();
        //Consulta y objeto sobre contacto  
        $contacts = $manager->getRepository(Contact::class)->findAll();
        //renderizar Vista
        return $this->render('contact/showContacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function new(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(AgendaBundlerType::class, $contact, array(
            'action' => $this->generateUrl('contact_new'),
            'method' => 'POST'
        ));

        $manager = $this->doctrine->getManager();

        $form->handleRequest($request);

        //Si el form es válido y se subió correctamente...
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($contact); //Agregar información en la memoria del Manager.
            $manager->flush(); // Procesar actualización o inserciones de datos.

            //Retornar a la ruta principal si es correcto todo.
            return $this->redirectToRoute('index');
        }
        return $this->render('contact\new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ContactController',
        ]);
    }

    public function edit(Request $request)
    {
		//Nuevo parámetro $idContact.
		$manager = $this->doctrine->getManager();

		//Consulta de CONTACTO Buscando por Id.
        $contact = $manager->getRepository(Contact::class)->find($request->get('id'));

		//Creación de Formulario para Editar (es el mismo Formulario de Creación).
		//Pasar el Objeto $contactoRepository que contiene la info  del contacto a editar. 
        $form = $this->createForm(AgendaBundlerType::class, $contact, array(
        ));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Agregar el Entitymanager y enviar los datos a insertar. 
            $manager->persist($contact);
            $manager->flush();
            //Redirigir a la vista que quieras en caso que sea exitoso
            return $this->redirectToRoute('contact_show');
        }
        return $this->render('contact\editContact.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request)
    {
        $manager = $this->doctrine->getManager();
        $contact = $manager->getRepository(Contact::class)->find($request->get('id'));
        if ($contact) {
            $manager->remove($contact);
            $manager->flush();
        }
        return $this->redirectToRoute('contact_show');
    }

}
