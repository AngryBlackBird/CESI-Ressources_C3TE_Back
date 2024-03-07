<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteResourcesController extends AbstractController
{

    public function __invoke(): Collection
    {
        /** @var User $user */
        $user = $this->getUser();
        return $user->getFavoris();
    }
}