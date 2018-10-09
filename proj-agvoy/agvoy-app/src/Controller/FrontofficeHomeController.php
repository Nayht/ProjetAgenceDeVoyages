<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="front")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $circuitsProgrammes = [];

        foreach ($em->getRepository(Circuit::class)->findAll() as $circuit) {
            if (sizeof($circuit->getProgrammationCircuits())>0) {
                array_push($circuitsProgrammes, $circuit);
            }
        }

        dump($circuitsProgrammes);

        return $this->render('front/home.html.twig', [
            'circuits' => $circuitsProgrammes,
            'controller_name' => 'FrontofficeHomeController',
        ]);
    }

    /**
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    public function circuitShow($id){
        $em = $this->getDoctrine()->getManager();

        $circuit = $em->getRepository(Circuit::class)->find($id);

        if (sizeof($circuit->getProgrammationCircuits())==0){
            $circuit=null;
        }

        dump($circuit);

        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
        ]);
    }
}
