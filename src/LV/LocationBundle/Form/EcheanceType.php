<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;


class EcheanceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('montantPaye')->add('montantTotal')->add('montantMensuel')->add('montantRestant')->add('datePremierPay', DateType::class,array('widget' => 'single_text'))->add('dateDernierPay', DateType::class,array('widget' => 'single_text'))->add('nbrePayRestant')->add('etat', ChoiceType::class, array('choices'=>array('Payé'=>'Payé', 'Non payé'=>'Non payé'), 'placeholder' => 'Sélectionner état'))->add('contartLeasing')->add('nomLeasing')->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture',
            'choice_label'=>'matricule','placeholder' => 'Sélectionner une Voiture','label'=>'Matricule :',));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Echeance'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_echeance';
    }


}
