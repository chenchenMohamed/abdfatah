<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContratType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numContrat')->add('dateContrat', DateType::class, array('data' => new \DateTime(),'widget' => 'single_text'))->add('recette')->add('refReservation', EntityType::class, array('class'=>'LocationBundle:Reservation', 'choice_label'=>'numReservation'))->add('kmDepart')->add('niveauCarburant', ChoiceType::class, array('choices'  => array('Niveau Haut' => 'Haut','Niveau Moyen' => 'Moyen','Niveau Bas' => 'Bas')))->add('etat',TextareaType::class)->add('conducteur1', EntityType::class, array('class'=>'LocationBundle:Client', 'placeholder' => 'Sélectionnez conducteur 1'))->add('conducteur2', EntityType::class, array('class'=>'LocationBundle:Client', 'placeholder' => 'Sélectionnez conducteur 2'))->add('nbreJour')->add('tarif');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Contrat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_contrat';
    }


}
