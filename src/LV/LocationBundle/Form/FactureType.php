<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FactureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numFacture', TextType::class,array('label'=>'Numéro Facture'))->add('dateFacture', DateType::class, array('data' => new \DateTime(),'widget' => 'single_text'))->add('refPayement', EntityType::class, array('label'=>'Numero Paiement','class'=>'LocationBundle:Paiement', 'choice_label'=>'id', 'placeholder' => 'Sélectionner num paiement'));//->add('refCheque', EntityType::class, array('class'=>'LocationBundle:Cheque', 'choice_label'=>'numCheque', 'multiple'=>true, 'expanded'=> true));//
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Facture'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_facture';
    }


}
