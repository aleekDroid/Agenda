<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LanguageController extends AbstractController
{
    public function changeLanguage(Request $request, string $locale): RedirectResponse
    {
        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $session->set('_locale', $locale);

        // if there is no referer header fall back to the homepage
        $url = $request->headers->get('referer', $this->generateUrl('index'));
        return $this->redirect($url);
    }
}
