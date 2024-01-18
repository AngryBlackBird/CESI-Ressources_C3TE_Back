<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Resource;
use App\Entity\State;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setEmail('email' . $i . '@email.fr');
            $user->setLastName('userLastName_' . $i);
            $user->setFirstName('userFirstName_' . $i);
            $user->setPhone('0701234567');
            $user->setRoles(['ADMIN']);
            $user->setActive(true);
            $password = $this->hasher->hashPassword($user, 'bonjour');
            $user->setPassword($password);
            $users[]= $user;
            $manager->persist($user);
        }
        $category = new Category();
        $category->setName('Catégorie 1');
        $manager->persist($category);

        $state = new State();
        $state->setName("Un State");
        $manager->persist($state);

        for ($i = 0; $i < 10; ++$i) {
            $ressource = new Resource();
            $ressource->setAuthor($users[0]);
            $ressource->setCategory($category);
            $ressource->setState($state);
            $ressource->setContent("Je suis un contenue __ " . $i);
            $ressource->setTitle("Je suis un titre  __ " . $i);
            $ressource->setPublishDate(new \DateTimeImmutable());
            $ressource->setActive(true);
            $manager->persist($ressource);
        }

        $manager->flush();
    }
}
