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

        $allCircuitsProgrammes = [];

        foreach ($em->getRepository(Circuit::class)->findAll() as $circuit) {
            $circuitsProgrammes=$circuit->getProgrammationCircuit();
            if (sizeof($circuitsProgrammes)>0) {
                foreach ($circuitsProgrammes as $programmation) {
                    array_push($allCircuitsProgrammes, $programmation);
                }
            }
        }

        $likes = $this->get('session')->get('likes');

        if ($likes == null){
            $likes = [];
        }

        return $this->render('front/front_circuits.html.twig', [
            'programmations' => $allCircuitsProgrammes,
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

        if (sizeof($circuit->getProgrammationCircuit())==0){
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

        $prog = $em->getRepository(ProgrammationCircuit::class)->find($id);

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

        $this->get('session')->set('likes', $likes);

        return $this->redirectToRoute('circuits');
    }

    /**
     * @Route("/likesCircuitSpecific/{id}", name="likes_circuit_specific")
     */
    public function likesCircuitSpecific($id){
        $em = $this->getDoctrine()->getManager();

        $prog = $em->getRepository(ProgrammationCircuit::class)->find($id);

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

        $this->get('session')->set('likes', $likes);

        return $this->redirectToRoute('front_circuit_show', ['id' => $prog->getCircuit()->getId()]);
    }

    /**
     * @Route("/viewlikes", name="view_likes")
     */
    public function viewLikes(){
        $em = $this->getDoctrine()->getManager();

        $likes = $this->get('session')->get('likes');

        if ($likes == null){
            $likes = [];
        }

        $this->get('session')->set('likes', $likes);

        $programmationsLikes= [];

        foreach ($likes as $like){
            $circuitLiked = $em->getRepository(ProgrammationCircuit::class)->find($like);
            if ($circuitLiked != null) {
                array_push($programmationsLikes, $circuitLiked);
            }
        }

        return $this->render('front/view_likes.html.twig', [
            'programmationsLikes' => $programmationsLikes,
            'likes' => $likes,
        ]);
    }
}
