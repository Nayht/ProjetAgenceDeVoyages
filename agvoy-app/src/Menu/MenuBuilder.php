<?php

// src/AppBundle/Menu/Builder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * MenuBuilder en tant que service (cf. http://symfony.com/doc/master/bundles/KnpMenuBundle/menu_builder_service.html)
 *
 */
class MenuBuilder
{
    private $factory;
    private $container;
    
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }

    public function createConnexionMenu(array $options){
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav ml-auto');


        $isConnected=false;
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $isConnected=true;
        }

        if($isConnected)
        {
            // Get username of the current logged in user
            $username = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
            $label = 'Bonjour, '. $username;
        }
        else
        {
            $label = 'Bonjour, aimable voyageur de l\'Internet';
        }

        $menu->addChild('User', array('label' => $label))
            ->setAttribute('class', 'usernameDisplay');

        if($isConnected) {
            $menu->addChild('Déconnexion', array('route' => 'fos_user_security_logout'))
                ->setAttributes(array(
                    'class' => 'nav-link',
                    'icon' => 'fa fa-list'
                ));
        }
        else{
            $menu->addChild('Connexion', array('route' => 'fos_user_security_login'))
                ->setAttributes(array(
                    'class' => 'nav-link',
                    'icon' => 'fa fa-list'
                ));
        }

        return $menu;

    }
    
    public function createBaseMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        $menu->addChild('Accueil', array('route' => 'home'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));

        $menu->addChild('Voyages', array('route' => 'circuits'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        $menu->addChild('Voyages aimés', array('route' => 'view_likes'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        return $menu;
    }
    
    public function createUserMenu(array $options)
    {
        $menu = $this->createBaseMenu($options);

        return $menu;
    }

    public function createAdminMenu(array $options)
    {
        $menu = $this->createUserMenu($options);

        // Children for connected users
        $menu->addChild('Editer les circuits', array('route' => 'admin_circuit_index'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        $menu->addChild('Editer les programmations', array('route' => 'admin_programmation_circuit_index'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        $menu->addChild('Editer les étapes', array('route' => 'admin_etape_index'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));


        return $menu;
    }
    
}
