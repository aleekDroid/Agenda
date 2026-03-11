<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    public function index( Request $request ): Response
    {
        $session = $request->getSession();
        if ($session) {
            $session->set('last_visited_section', 'home');
        } else {
            return $this->redirect($this->requestStack->getCurrentRequest()->headers->get('referer', $this->generateUrl('index')));
        }

        $session->remove('usuario_id');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
