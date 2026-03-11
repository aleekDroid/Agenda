<?php
namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event)
    {
        // only modify the main request (ignore sub-requests)
        if (method_exists($event, 'isMainRequest') ? !$event->isMainRequest() : !$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        if (!$session || !$session->has('_locale')) {
            return;
        }

        $locale = $session->get('_locale');
        $request->setLocale($locale);

    }

    public static function getSubscribedEvents()
    {

        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}