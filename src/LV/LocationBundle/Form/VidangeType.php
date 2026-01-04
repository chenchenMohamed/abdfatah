<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VidangeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numVidange')->add('dateVidange', DateType::class, array('data' => new \DateTime(),'widget' => 'single_text'))->add('prochVidange')->add('compteur')->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture', 'choice_label'=>'matricule','placeholder' => 'Sélectionner une Voiture','label'=>'Matricule :',))->add('montant');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Vidange'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_vidange';
    }


}
