<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class SoustraitanceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numSoustraitance')->add('nbrePayRestant')->add('montantTotal')->add('montantPaye')->add('montantMensuel')->add('montantRestant')->add('datePremierPay', DateType::class,array('widget' => 'single_text'))->add('dateDernierPay', DateType::class,array('widget' => 'single_text'))->add('etat', ChoiceType::class, array('choices'=>array('Payé'=>'Payé', 'Non payé'=>'Non payé'), 'placeholder' => 'Sélectionner état'))->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture'))->add('refClient', EntityType::class, array('class'=>'LocationBundle:Client', 'placeholder'=>'Sélectionner client'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Soustraitance'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_soustraitance';
    }


}
