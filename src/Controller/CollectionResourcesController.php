<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\EState;
use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CollectionResourcesController extends AbstractController
{
    public function __invoke(Request $request, ResourceRepository $resourceRepository): Collection|array
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($request->get('filter') && $user) {
            $filter = $request->get('filter');
            if ($filter === 'favorite') {
                return $user->getFavoris();
            } elseif ($filter === 'me') {
                return $user->getResources();
            }
        }

        $queryBuilder = $resourceRepository->createQueryBuilder('r');
        $queryBuilder->andWhere($queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('r.state', ':state'),
            $queryBuilder->expr()->eq('r.author', ':current_user')
        ))
            ->setParameter('state', EState::PUBLIC->name)
            ->setParameter('current_user', $user?->getId());

        return $queryBuilder->getQuery()->getResult();
    }
}