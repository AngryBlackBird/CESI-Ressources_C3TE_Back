<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Resource;
use App\Entity\User;
use App\Enum\EState;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface
{
    public function __construct(private readonly Security $security)
    {
    }

    public function applyToCollection(QueryBuilder                $queryBuilder,
                                      QueryNameGeneratorInterface $queryNameGenerator,
                                      string                      $resourceClass,
                                      Operation                   $operation = null,
                                      array                       $context = []): void
    {
        if ($resourceClass === Resource::class) {
            $alias = $queryBuilder->getRootAliases()[0];
            /** @var User $user */
            $user = $this->security->getUser();
            $queryBuilder
                ->orWhere("$alias.state = :state")
                ->orWhere("$alias.author = :current_user")
                ->setParameter('current_user', $user?->getId() )
                ->setParameter('state', EState::PUBLIC->name);
        }
    }
}