<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

final class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @var User $currentUser */
        $currentUser = $event->getUser();;
        $payload = $event->getData();

        $payload['firstName'] = $currentUser->getFirstName();
        $payload['lastName'] = $currentUser->getLastName();
        $payload['id'] = $currentUser->getId();

        $event->setData($payload);

        $header = $event->getHeader();

        $event->setHeader($header);
    }
}