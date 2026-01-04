<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RetourType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('km')->add('etatRetour')->add('degats', ChoiceType::class, array('choices'  => array('Non' => false,'oui' => true)))->add('refClient', EntityType::class, array('class'=>'LocationBundle:Client','placeholder' => 'Sélectionner un client','label'=>'Client :'))->add('refVoiture', EntityType::class, array('class'=>'LocationBundle:Voiture','placeholder' => 'Sélectionner une Voiture','label'=>'Matricule :'))->add('refContrat', EntityType::class, array('class'=>'LocationBundle:Contrat', 'choice_label'=>'numContrat','placeholder' => 'Sélectionner un Contrat','label'=>'Numero Contrat :', 'required' => false))->add('refCsr', EntityType::class, array('class'=>'LocationBundle:CSR', 'choice_label'=>'numContrat','placeholder' => 'Sélectionner un Contrat','label'=>'Numero Contrat :'))->add('etatRetour', TextareaType::class,array('label' => 'Etat de retour'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Retour'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_retour';
    }


}
