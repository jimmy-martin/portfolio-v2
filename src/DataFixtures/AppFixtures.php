<?php

namespace App\DataFixtures;

use App\Entity\Project;
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

        for ($index = 1; $index <=5; $index++) {
            $project = new Project();
            $project->setTitle('Projet ' . $index);
            $project->setSummary('Un extrait du projet ' . $index);
            $project->setDescription('Voici la description entière du projet n°' . $index);
            $project->setGithub('https://user/project' . $index);
            $project->setUrl('https://project' . $index);
            $project->setUser($user);
            $project->setCreatedAt(new \DateTime());
            $project->setUpdatedAt(new \DateTime());
            
            $manager->persist($project);
        }

        $manager->persist($user);
        $manager->flush();
    }
}