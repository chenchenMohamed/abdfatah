<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DisponibiliteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDebut', DateTimeType::class,array('data' => new \DateTime(),'input' => 'datetime','widget' => 'single_text'))->add('dateFin', DateTimeType::class,array('data' => new \DateTime(),'input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))->add('etat', ChoiceType::class, array('choices'=>array('Louée'=>'Louée', 'Réservée'=>'Réservée', 'En panne'=>'En panne','En maintenance'=>'En maintenance'), 'placeholder' => 'Sélectionner etat'))->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture', 'choice_label'=>'matricule', 'placeholder' => 'Sélectionner une voiture'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Disponibilite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_disponibilite';
    }


}
