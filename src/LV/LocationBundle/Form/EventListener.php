<?php

namespace LV\LocationBundle\EventListener;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use LV\LocationBundle\Entity\Marque
use LV\LocationBundle\Entity\Modele
 
class AddModeleFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToModele;
 
    public function __construct($propertyPathToModele)
    {
        $this->propertyPathToModele = $propertyPathToModele;
    }
 
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA  => 'preSetData',
            FormEvents::PRE_SUBMIT    => 'preSubmit'
        );
    }
 
    private function addModeleForm($form, $marque_id)
    {
        $formOptions = array(
            'class'         => 'LocationBundle:Modele',
            'empty_value'   => 'Ciudad',
            'label'         => 'Ciudad',
            'attr'          => array(
                'class' => 'modele_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($marque_id) {
                $qb = $repository->createQueryBuilder('modele')
                    ->innerJoin('modele.marque', 'marque')
                    ->where('marque.id = :marque')
                    ->setParameter('marque', $marque_id)
                ;
 
                return $qb;
            }
        );
 
        $form->add($this->propertyPathToModele, 'entity', $formOptions);
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
        $accessor    = PropertyAccess::createPropertyAccessor();
 
        $modele        = $accessor->getValue($data, $this->propertyPathToModele);
        $marque_id     = ($modele) ? $modele->getMarque()->getId() : null;
 
        $this->addModeleForm($form, $marque_id);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        $marque_id = array_key_exists('marque', $data) ? $data['marque'] : null;
 
        $this->addCityForm($form, $marque_id);
    }
}

class AddMarqueFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToModele;
 
    public function __construct($propertyPathToModele)
    {
        $this->propertyPathToModele = $propertyPathToModele;
    }
 
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }
 
    private function addCountryForm($form, $marque = null)
    {
        $formOptions = array(
            'class'         => 'LocationBundle:Marque',
            'mapped'        => false,
            'label'         => 'País',
            'empty_value'   => 'País',
            'attr'          => array(
                'class' => 'marque_selector',
            ),
        );
 
        if ($marque) {
            $formOptions['data'] = $marque;
        }
 
        $form->add('marque', 'entity', $formOptions);
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
        $accessor = PropertyAccess::getPropertyAccessor();
 
        $modele    = $accessor->getValue($data, $this->propertyPathToModele);
        $marque    = ($modele) ? $modele->getMarque() : null;
 
        $this->addMarqueForm($form, $marque);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
 
        $this->addMarqueForm($form);
    }
}