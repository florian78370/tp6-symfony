<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Album;
use App\Entity\Style;
use App\Entity\Artiste;
use App\Entity\Morceau;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=Factory::create("fr_FR");
        $LesStyles=$this->chargeFichier("style.csv");
        foreach ($LesStyles as $value) {
            $style= new Style();
            $style->setId(intval($value[0]))
                        ->setNom($value[1])
                        ->setCouleur($faker->safeColorName());
            $manager->persist($style);
            $this->addReference("style". $style->getId(),$style);
        }

        $LesArtistes=$this->chargeFichier("artiste.csv");

        $genres=["men","women"];
        foreach ($LesArtistes as $value) {
            $artiste= new Artiste();
            $artiste    ->setId(intval($value[0]))
                        ->setNom($value[1])
                        ->setDescription("<p>". join("</p><p>", $faker->paragraphs(5))."</p>")
                        ->setSite($faker->url())
                        ->setImage('https://randomuser.me/api/portraits/' .$faker->randomElement($genres)."/" .mt_rand(1,99).".jpg")
                        ->setType($value[2]);
            $manager->persist($artiste);
            $this->addReference("artiste". $artiste->getId(),$artiste);
        }
        

        $lesalbum=$this->chargeFichier("album.csv");
        foreach ($lesalbum as $value) 
        {
            $album=new Album();
            $album ->setId(intval($value[0]))
                   ->setNom($value[1])
                   ->setDate(intval($value[2]))
                   ->setImage($faker->imageUrl(640,480))
                   -> addStyle($this->getReference("style".$value[3]))
                   -> setartiste($this->getReference("artiste".$value[4]))
                   ->setImage('https://lorempicture.point-sys.com/400/300/' .mt_rand(1,30));
                   $manager->persist($album);
                   $this->addReference("album".$album->getId(),$album);

        }

        $lesmorceau=$this->chargeFichier("morceau.csv");
        
        foreach ($lesmorceau as $value) 
        {
            $morceau=new Morceau();
            $morceau ->setId(intval($value[0]))
                   ->setTitre($value[2])
                   -> setalbum($this->getReference("album".$value[1]))
                   ->setDurée(date("i:s",$value[3])) 
                   ->setPiste(intval($value[4]));   
                   $manager->persist($morceau);
                   $this->addReference("Moreaux".$morceau->getId(),$morceau);
                   
        }
        $manager->flush();
    }

    public function chargeFichier($fichier) 
    {
        $fichierCsv=fopen(__DIR__. "/". $fichier ,"r");
        while (!feof($fichierCsv)) {
            $data[] = fgetcsv($fichierCsv);
        }
        fclose($fichierCsv);
        return $data;
    }
}
