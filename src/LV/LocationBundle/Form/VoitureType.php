<?php

namespace LV\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use LV\LocationBundle\Entity\Marque;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VoitureType extends AbstractType
{
    private $em;
    
    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /** 
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('matricule')//->add('marque', EntityType::class, array('class'=>'LocationBundle:Marque', 'choice_label'=>'nom','placeholder'=>'Sélectionner la marque', 'mapped'=>false, 'required'=>false))->add('modele')//
        ->add('couleur')
        ->add('codeRadio')
        ->add('prix')
        ->add('km')
        ->add('etat', ChoiceType::class, array('choices'=>array('Location'=>'Location', 'Soustraitance'=>'Soustraitance')))
        ->add('photo', FileType::class, array('data_class' => null, 'required'=>false))
        ->add('disponibilite')
        ->add('montantTotal')
        ->add('montantMensuel')
        ->add('datePremierPay', DateType::class,array('widget' => 'single_text'))
        ->add('dateDernierPay', DateType::class,array('widget' => 'single_text'))
        ->add('miseEnCirculation', DateType::class,array('widget' => 'single_text'))
        ->add('fournisseur')
        ->add('numContrat')
        ->add('autoFinancement')
        ->add('nbrePayRestant')
        ->add('totalDepenses')
        ->add('isEnable');
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
       
    }

   protected function addElements(FormInterface $form, Marque $marque = null) {
        // 4. Add the province element
        $form->add('marque', EntityType::class, array(
            'required' => true,
            'data' => $marque,
            'placeholder' => 'Sélectionner une marque',
            'class' => 'LocationBundle:Marque',
            //'mapped' => false
        ));
        
        // Neighborhoods empty, unless there is a selected City (Edit View)
        $modeles = array();
        
        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($marque) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoModele = $this->em->getRepository('LocationBundle:Modele');
            
            $modeles = $repoModele->createQueryBuilder("q")
                ->where("q.marque = :marqueid")
                ->setParameter("marqueid", $marque->getId())
                ->getQuery()
                ->getResult();
        }
        
        // Add the Neighborhoods field with the properly data
        $form->add('modele', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Sélectionner un modèle',
            'class' => 'LocationBundle:Modele',
            'choices' => $modeles
        ));
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        
        // Search for selected City and convert it into an Entity
        $marque = $this->em->getRepository('LocationBundle:Marque')->find($data['marque']);
        
        $this->addElements($form, $marque);
    }

    function onPreSetData(FormEvent $event) {
        $voiture = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $marque = $voiture->getMarque() ? $voiture->getMarque() : null;
        
        $this->addElements($form, $marque);
    }




    


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\LocationBundle\Entity\Voiture'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_locationbundle_voiture';
    }


}
