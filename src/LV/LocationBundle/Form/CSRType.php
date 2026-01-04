<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityRepository;

class CSRType extends AbstractType
{
    /** 
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numContrat')->add('dateContrat', DateType::class, array('data'=>new \DateTime(), 'widget' => 'single_text'))->add('dateDebut', DateTimeType::class, array('widget' => 'single_text'))->add('dateFin', DateTimeType::class, array('widget' => 'single_text'))->add('nbreJour')->add('kmDepart')->add('kmRetour')->add('niveauCarburant', ChoiceType::class, array('choices'  => array('0' => '0','1/4' => '1/4','1/2' => '1/2', '3/4' => '3/4' ,'Full' => 'Full'), 'placeholder'=>'Sélectionner niveau carburant'))->add('tarif')->add('recette')->add('etat', TextareaType::class, array('required' => false))->add('etatRetour', TextareaType::class, array('required' => false))->add('conducteur1', EntityType::class, array('class'=>'LocationBundle:Client', 'placeholder'=>'Sélectionner conducteur 1', 'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ->where('v.disponibilite = true')
            ;}))->add('conducteur2', EntityType::class, array('class'=>'LocationBundle:Client', 'placeholder'=>'Sélectionner conducteur 2','required' => false, 'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ->where('v.disponibilite = true')
            ;}))->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture', 'choice_label'=>'matricule'))->add('garant', NumberType::class, array('required' => false))->add('fraisAeroport', NumberType::class, array('required' => false))->add('siegeBebe', NumberType::class, array('required' => false))->add('supplement', NumberType::class, array('required' => false))->add('carburant', NumberType::class, array('required' => false))->add('totalHTVA')->add('TVA')->add('sousTotal')->add('timbre')->add('total')->add('degats', ChoiceType::class, array('choices'  => array('Non' => false,'Oui' => true), 'required' => false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\CSR'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_csr';
    }


}
