<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;


class VisiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numVisite')->add('dateVisite', DateType::class, array('data' => new \DateTime(),'widget' => 'single_text'))->add('dateProchVisite', DateType::class, array('widget' => 'single_text','label'=>'Date prochaine visite :'))->add('montant')->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture','placeholder' => 'Sélectionner une Voiture',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('v')
            ->select('v')
            ->andwhere('v.disponibilite = true')
            ;}, 
            'label'=>'Matricule :'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Visite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_visite';
    }


}
