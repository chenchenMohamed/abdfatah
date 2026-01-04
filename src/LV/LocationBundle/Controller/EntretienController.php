<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Visite;
use LV\LocationBundle\Entity\Vidange;
use LV\LocationBundle\Entity\Echeance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use LV\LocationBundle\Form\VoitureType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;



/**
 * Voiture controller.
 *
 */
class EntretienController extends Controller
{
   
    public function indexAction(Request $request, $id)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('voiture', EntityType::class, array('class'=>'LocationBundle:Voiture', 'choice_label'=>'matricule', 'placeholder' => 'Sélectionner une voiture',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('c')
            ->select('c')
            ->where('c.etat = :etat')
            ->andWhere('c.disponibilite = 1')
            ->setParameter('etat', 'Location')
            ;}))
        ->getForm();

        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository('LocationBundle:Voiture')->findOneById($id);
           
        $form->get('voiture')->setData($vehicule);

        $visites = $em->getRepository('LocationBundle:Visite')->findByRefVoiture($vehicule);
        $vidanges = $em->getRepository('LocationBundle:Vidange')->findByRefVoiture($vehicule);
        $voitures = $em->getRepository('LocationBundle:Voiture')->findBy(['disponibilite' => 1]);
            
        return $this->render('entretien/index.html.twig', array(
            'form' => $form->createView(),
            'visites' => $visites,
            'vidanges' => $vidanges,
            'voitures' => $voitures,
            'id' => $id,
            'vehicule' => $vehicule,
        ));

    }

     public function index1Action($voiture)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('voiture', EntityType::class, array('class'=>'LocationBundle:Voiture', 'choice_label'=>'matricule', 'placeholder' => 'Sélectionner une voiture'))
        ->getForm();

        $em = $this->getDoctrine()->getManager();
        $veh = $em->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);

        $form->get('voiture')->setData($veh);
        $visites = $em->getRepository('LocationBundle:Visite')->findAll();
        $vidanges = $em->getRepository('LocationBundle:Vidange')->findAll();
        $echeances = $em->getRepository('LocationBundle:Echeance')->findAll();
        $voitures = $em->getRepository('LocationBundle:Voiture')->findAll();
        
        return $this->render('entretien/index1.html.twig', array(
            'form' => $form->createView(),
            'visites' => $visites,
            'vidanges' => $vidanges,
            'echeances' => $echeances,
            'voitures' => $voitures,
            'vehicule'=>$voiture,

        ));

    }

   

}
