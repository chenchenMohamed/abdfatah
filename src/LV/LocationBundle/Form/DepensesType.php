<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityRepository;

class DepensesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('codeDepense')->add('description',TextareaType::class)->add('montant')->add('refAgence', EntityType::class, array('class'=>'LocationBundle:Agence', 'choice_label'=>'nom'))->add('refUtilisateur')->add('dateDepense', DateType::class,array('data' => new \DateTime(),'input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ->where('v.disponibilite = true')
            ;},
            'choice_label'=>'matricule','placeholder' => 'Sélectionner une voiture','label'=>'Matricule :', 'required'=>false))
            ->add('refTypeDepense', EntityType::class, array('class'=>'LocationBundle:TypeDepenses',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ;},
            'choice_label'=>'label','placeholder' => 'Sélectionner un type de depense','label'=>'Type :', 'required'=>false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Depenses'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_depenses';
    }


}
