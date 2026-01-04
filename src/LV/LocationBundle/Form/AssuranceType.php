<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;

class AssuranceType extends AbstractType
{
    /** 
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numAssurance', TextType::class,array('label'=>'Numero Assurance'))->add('nomAssurance')->add('dateAssurance', DateType::class, array('widget' => 'single_text'))->add('dateProchAssurance', DateType::class, array('widget' => 'single_text','label'=>'Date Prochaine Assurance','months'=>range(date('Y-m-d'),date('m')+1)))->add('montant')->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ->where('NOT EXISTS (SELECT s FROM LV\LocationBundle\Entity\Soustraitance s WHERE v = s.refVoiture AND s.etat = :etat)')
            ->andwhere('v.disponibilite = true')
            ->setParameter('etat', 'Payé')

            ;},
            'choice_label'=>'matricule','placeholder' => 'Sélectionner une Voiture','label'=>'Matricule :','multiple'=>true));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Assurance'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_assurance';
    }


}
