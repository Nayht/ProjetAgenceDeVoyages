<?php
/**
 * Gestion de la page d'accueil de l'application
 *
 * @copyright  2017 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur de la page d'accueil
 */
class IndexController extends Controller
{    
    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function indexAction()
    {
        return $this->render('home.html.twig',array(
            'welcome' => "Bienvenue sur Algonyr, l'agence de voyages du futur de l'Internet des objets connectés")
            );
    }
}
