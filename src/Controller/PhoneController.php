<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Phone;
use App\Form\PhonesType;

final class PhoneController extends AbstractController
{

    public function showPhones(): Response
    {
        $manager = $this->doctrine->getManager();
        $phones = $manager->getRepository(Phone::class)->findAll();

        return $this->render('phone/showPhones.html.twig', [
            'phones' => $phones,
        ]);
    }

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function newPhone(Request $request)
    {
        $phone = new Phone();
        $form = $this->createForm(PhonesType::class, $phone, array(
            'action' => $this->generateUrl('phone_new'),
            'method' => 'POST'
        ));

        $manager = $this->doctrine->getManager();

        $form->handleRequest($request);

        // Validamos si el form se ha enviado y es válido.
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($phone); // Se agrega el nuevo teléfono a la memoria del Manager.
            $manager->flush(); // Se procesan las actualizaciones o inserciones de datos.

            return $this->redirectToRoute('index');
        }
        return $this->render('phone/newPhone.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        public function editPhone(Request $request)
    {
		$manager = $this->doctrine->getManager();

        $phone = $manager->getRepository(Phone::class)->find($request->get('id'));

		//Creación de Formulario para Editar (es el mismo Formulario de Creación).
        $form = $this->createForm(PhonesType::class, $phone, array(
        ));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Agregar el Entitymanager y enviar los datos a insertar. 
            $manager->persist($phone);
            $manager->flush();
            //Redirigir a la vista que quieras en caso que sea exitoso
            return $this->redirectToRoute('phone_show');
        }
        return $this->render('phone\editPhone.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    public function deletePhone(Request $request)
    {
        $manager = $this->doctrine->getManager();
        $phone = $manager->getRepository(Phone::class)->find($request->get('id'));
        if ($phone) {
            $manager->remove($phone);
            $manager->flush();
        }
        return $this->redirectToRoute('phone_show');
    }
}
