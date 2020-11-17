<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserProfilFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Query\AST\Functions\LowerFunction;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface 
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {

        $this->encoder = $encoder;
        
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($k=0; $k <=3 ; $k++) { 
            
            $profil = $this->getReference("profil".$k);
            for ($i = 0; $i < 4; $i++) {
                $user = new User();
                $user->setUsername( strtolower($profil->getLibelle()). $i);
                $user->setFirstname($faker->firstName());
                $user->setLastname($faker->lastName());
                
                $user->setProfil($profil);
                
                $password = $this->encoder->encodePassword($user, 'pass_1234');
                $user->setPassword($password);
                $manager->persist($user);
                
            }
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserProfilFixtures::class,
        );
    }

    public function getOrder(){
        return 2;
    }
}
