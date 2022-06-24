<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Quote;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTestFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername("testusername");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'testpassword'
        ));
        $manager->persist($user);
        $manager->flush();


    }


}



