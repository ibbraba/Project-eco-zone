<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Quote;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher;

class TestFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<10; $i++) {

            $article = new Article();
            $article->setTitre("Article$i")
                ->setContent("Voici l'article $i")
                ->setDate(new \DateTime())
                ->setPreview("Article $i preview")
                ->setViews(10);
                if($i < 7 ){
                    $article->setCategorie("bourse");
                }else{
                    $article->setCategorie("livres");
                }


            $manager->persist($article);
        }








        $quote = new Quote();
        $quote->setTitre("Titre")
            ->setAuteur("moi")
            ->setContenu("Le contenu de moi")
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($quote);
        $manager->flush();
    }
}