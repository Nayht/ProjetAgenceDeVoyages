<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/circuits", name="circuits")
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

        $likes = $this->get('session')->get('likes');

        if ($likes == null){
            $likes = [];
        }

        return $this->render('front/home.html.twig', [
            'circuits' => $circuitsProgrammes,
            'controller_name' => 'FrontofficeHomeController',
            'likes' => $likes,
        ]);
    }

    /**
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    public function circuitShow($id){
        $em = $this->getDoctrine()->getManager();

        $circuit = $em->getRepository(Circuit::class)->find($id);

        if (sizeof($circuit->getProgrammationCircuits())==0){
            return $this->redirectToRoute('circuits');
        }

        $likes = $this->get('session')->get('likes');

        if ($likes == null){
            $likes = [];
        }

        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
            'likes' => $likes,
        ]);
    }

    /**
     * @Route("/likes/{id}", name="likes")
     */
    public function likes($id){
        $em = $this->getDoctrine()->getManager();

        $circuit = $em->getRepository(Circuit::class)->find($id);

        $likes = $this->get('session')->get('likes');

        if ($likes == null){
            $likes = [];
        }

        //Si l'identifiant n'est pas présent dans le tableau des likes, on l'ajoute
        if (! in_array($id, $likes) )
        {
            $likes[] = $id;
        }
        else //Sinon, on le retire du tableau
        {
            $likes = array_diff($likes, array($id));
        }

        //Si le circuit n'est pas dans la liste des circuit sprogrammés, on n'update pas la variable likes
        if (sizeof($circuit->getProgrammationCircuits())==0){
            return $this->redirectToRoute('circuits');
        }

        $this->get('session')->set('likes', $likes);

        return $this->redirectToRoute('circuits');
    }

    /**
     * @Route("/likesCircuitSpecific/{id}", name="likes_circuit_specific")
     */
    public function likesCircuitSpecific($id){
        $em = $this->getDoctrine()->getManager();

        $circuit = $em->getRepository(Circuit::class)->find($id);

        $likes = $this->get('session')->get('likes');

        if ($likes == null){
            $likes = [];
        }

        //Si l'identifiant n'est pas présent dans le tableau des likes, on l'ajoute
        if (! in_array($id, $likes) )
        {
            $likes[] = $id;
        }
        else //Sinon, on le retire du tableau
        {
            $likes = array_diff($likes, array($id));
        }

        //Si le circuit n'est pas dans la liste des circuit sprogrammés, on n'update pas la variable likes
        if (sizeof($circuit->getProgrammationCircuits())==0){
            return $this->redirectToRoute('circuits');
        }

        $this->get('session')->set('likes', $likes);

        return $this->redirectToRoute('front_circuit_show', ['id' => $id]);
    }
}
