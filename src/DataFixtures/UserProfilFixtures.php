<?php

namespace App\DataFixtures;

use App\Entity\UserProfil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserProfilFixtures extends Fixture
{


    public const PROFIL_REFERENCE = 'profil';
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $profils = ["ADMIN", "FORMATEUR", "APPRENANT", "CM"];
        foreach ($profils as $libelle) {


            $profil = new UserProfil();
            $profil->setLibelle($libelle);
            $manager->persist($profil);

            if ($libelle == "ADMIN") {
                $this->addReference("admin0", $profil);
            } elseif ($libelle == "APPRENANT") {
                $this->addReference("admin1", $profil);
            } elseif ($libelle == "FORMATEUR") {
                $this->addReference("admin2", $profil);
            } elseif ($libelle == "CM") {
                $this->addReference("admin3", $profil);
            }
        }

        $manager->flush();
    }
}
