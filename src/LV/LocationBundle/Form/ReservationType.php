<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;


class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numReservation')->add('dateResevation', DateType::class, array('widget' => 'single_text','label'=>'Date Réservation'))->add('dateDebut', DateTimeType::class, array('widget' => 'single_text'))->add('dateFin', DateTimeType::class, array('widget' => 'single_text'))->add('nbreJour')->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture','placeholder' => 'Sélectionner une Voiture','label'=>'Matricule :'))->add('refClient', EntityType::class, array('class'=>'LocationBundle:Client', 'placeholder' => 'Sélectionnez un client', 'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ->where('v.disponibilite = true')
            ;}));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_reservation';
    }


}
