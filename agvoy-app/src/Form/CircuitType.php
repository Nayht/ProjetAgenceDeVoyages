<?php

namespace App\Form;

use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CircuitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('paysDepart')
            ->add('villeDepart')
            ->add('villeArrivee')
            ->add('etapes', CollectionType::class, array(
                'entry_type' => EtapeTypeFromCircuit::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('programmationCircuit', CollectionType::class, array(
                'entry_type' => ProgrammationCircuitTypeFromCircuit::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Circuit::class,
        ]);
    }
}
