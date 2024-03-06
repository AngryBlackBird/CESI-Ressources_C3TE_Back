<?php

namespace App\EventListener;
// src/App/EventListener/JWTCreatedListener.php

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

final class JWTCreatedListener
{
    private Security $security;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /**
         * @var User $currentUser
         */
        $currentUser = $this->security->getUser();
        $payload = $event->getData();

        $payload['firstName'] = $currentUser->getFirstName();
        $payload['lastName'] = $currentUser->getLastName();
        $payload['id'] = $currentUser->getId();

        $event->setData($payload);

        $header = $event->getHeader();

        $event->setHeader($header);
    }
}