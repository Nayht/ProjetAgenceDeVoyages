<?php

namespace App\DataFixtures;

use App\Entity\ProgrammationCircuit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProgrammationCircuitData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $circuit=$this->getReference('andalousie-circuit');

        $programmationCircuit = new ProgrammationCircuit();
        $programmationCircuit->setNombrePersonnes(10);
        $programmationCircuit->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
        $programmationCircuit->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2017-09-09"));
        $programmationCircuit->setPrix(2000);
        $circuit->addProgrammationCircuit($programmationCircuit);
        $manager->persist($programmationCircuit);
        $manager->persist($circuit);

        $circuit=$this->getReference('idf-circuit');
        $programmationCircuit = new ProgrammationCircuit();
        $programmationCircuit->setNombrePersonnes(15);
        $programmationCircuit->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2016-04-04"));
        $programmationCircuit->setPrix(1500);
        $circuit->addProgrammationCircuit($programmationCircuit);
        $manager->persist($programmationCircuit);
        $manager->persist($circuit);

        $manager->flush();
    }
}
