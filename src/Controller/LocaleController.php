<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LocaleController extends AbstractController
{
    public function changeLanguage(Request $request, string $locale): RedirectResponse
    {
        $session = $request->getSession();
        $session->set('_locale', $locale);

        $url = $request->headers->get('referer', $this->generateUrl('index'));
        return $this->redirect($url);
    }
}
