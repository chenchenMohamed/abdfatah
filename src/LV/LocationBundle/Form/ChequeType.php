<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChequeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numCheque', TextType::class,array('label'=>'Numero Chèque'))->add('banque', TextType::class,array('label'=>'Nom du Banque'))->add('monatant', TextType::class,array('label'=>'Montant'))->add('nomProp', TextType::class,array('label'=>'Nom Proprietaire'))->add('dateValidation', DateType::class, array('data' => new \DateTime(),'widget' => 'single_text','label'=>'Date Validation'))->add('etat', ChoiceType::class, array('choices'=>array('Non payé'=>'Non payé', 'Payé'=>'Payé'), 'preferred_choices'=> array('Non Payé')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Cheque'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_cheque';
    }


}
