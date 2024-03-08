<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Resource;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected Generator $faker;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setEmail('email' . $i . '@email.fr');
            $user->setLastName($this->faker->lastName);
            $user->setFirstName($this->faker->firstName);
            $user->setPhone('076697444');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setActive(true);
            $password = $this->hasher->hashPassword($user, 'bonjour');
            $user->setPassword($password);
            $users[] = $user;
            $manager->persist($user);
        }
        $category = new Category();
        $category->setName($this->faker->title);
        $manager->persist($category);


        $ressources = [];
        for ($i = 0; $i < 10; ++$i) {
            $ressource = new Resource();
            $ressource->setAuthor($users[0]);
            $ressource->setCategory($category);
            $ressource->setContent($this->faker->text(500));
            $ressource->setTitle($this->faker->text(15));
            $ressource->setPublishDate(new \DateTimeImmutable());
            $ressource->setActive($this->faker->boolean(70));

            $manager->persist($ressource);
            $ressources[] = $ressource;
        }
        $users[0]->addFavori($ressources[0]);
        $users[0]->addFavori($ressources[1]);
        $users[0]->addFavori($ressources[2]);

        $manager->persist($users[0]);

        $manager->flush();
    }
}
