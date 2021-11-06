<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\OperatingSystem;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\Software;
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
        $user->setPresentation("Après cette formation, j'aimerais continuer mes études par le moyen de l'alternance. Ainsi, si mon profil vous intéresse, je vous laisse utiliser le formulaire de contact ou bien mes liens vers mes différents réseaux sociaux afin de me contacter.");
        $manager->persist($user);

        for ($index = 1; $index <= 3; $index++) {
            $skill = new Skill();
            $skill->setName('Skill ' . $index);
            $skill->addUser($user);
            $manager->persist($skill);

            $software = new Software();
            $software->setName('Logiciel ' . $index);
            $software->addUser($user);
            $manager->persist($software);

            $os = new OperatingSystem();
            $os->setName('Système d\'exploitation ' . $index);
            $os->addUser($user);
            $manager->persist($os);
        }

        $categoryOne = new Category();
        $categoryOne->setName('Catégorie 1');
        $manager->persist($categoryOne);

        $categoryTwo = new Category();
        $categoryTwo->setName('Catégorie 2');
        $manager->persist($categoryTwo);

        $categoryThree = new Category();
        $categoryThree->setName('Catégorie 3');
        $manager->persist($categoryThree);


        for ($index = 1; $index <= 5; $index++) {
            $project = new Project();
            $project->setTitle('Projet ' . $index);
            $project->setSummary('Un extrait du projet ' . $index);
            $project->setDescription('Voici la description entière du projet n°' . $index);
            $project->setGithub('https://user/project' . $index);
            $project->setUrl('https://project' . $index);
            $project->setUser($user);
            $project->setCreatedAt(new \DateTime());
            $project->setUpdatedAt(new \DateTime());

            $project->addCategory($categoryOne);

            $project->addCategory($categoryTwo);

            $project->addCategory($categoryThree);

            $manager->persist($project);
        }


        $manager->flush();
    }
}
