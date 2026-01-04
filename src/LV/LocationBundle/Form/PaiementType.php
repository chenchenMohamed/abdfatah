<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaiementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datePayement', DateType::class,array('label'=>'Date Paiement','input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))->add('dateProchPayement', DateType::class, array('label'=>'Date Prochaine Paiement','required' => false, 'input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))->add('refContrat', EntityType::class, array('label'=>'Numero de Contrat','class'=>'LocationBundle:Contrat', 'choice_label'=>'numContrat', 'placeholder' => 'Sélectionner num contrat','required' => false))->add('montantPaye', TextType::class,array('label'=>'Montant Payée'))->add('montantRestant', TextType::class,array('label'=>'Montant Restant'))->add('typePayement', ChoiceType::class, array('placeholder' => 'Sélectionner type', 'label'=>'Type Paiement','choices'=>array('Espèce'=>'Espèce','Chèque'=>'Chèque','Virement bancaire'=>'Virement bancaire')))->add('numCheque', IntegerType::class, array('required' => false))->add('numVirement', IntegerType::class, array('required' => false))->add('refCsr', EntityType::class, array('label'=>'Numero de Contrat','required' => false ,'class'=>'LocationBundle:CSR', 'choice_label'=>'numContrat', 'placeholder' => 'Sélectionner num contrat'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Paiement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_paiement';
    }


}
