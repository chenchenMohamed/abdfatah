<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cin')->add('nom')->add('prenom')->add('telephone')->add('numPermis')->add('nationalite')->add('adresse')->add('degat', ChoiceType::class, array('choices'  => array('Non' => false,'Oui' => true,)))->add('cause', TextareaType::class, array('label' => 'Cause','required'=>false))->add('disponibilite')->add('delivre', DateType::class, array('widget' => 'single_text','required'=>false))->add('dateNaissance', DateType::class, array('widget' => 'single_text','required'=>false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_client';
    }


}
