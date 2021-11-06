<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname('Jimmy');
        $user->setLastname('Martin');
        $user->setAge(21);
        $user->setProfil('Développeur PHP / Symfony / Laravel');
        $user->setEmail('jimmy.martin952@gmail.com');
        $user->setGithub('https://github.com/jimmy-martin');
        $user->setTwitter('https://twitter.com/jimmydev_');
        $user->setLinkedin('https://www.linkedin.com/in/jimmy-martin-dev/');

        $manager->persist($user);
        $manager->flush();
    }
}
