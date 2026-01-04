<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Disponibilite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use LV\LocationBundle\Entity\Voiture;


/**
 * Disponibilite controller.
 *
 */
class DisponibiliteController extends Controller
{
    public function searchAction(Request $request)
{
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('disponibilite_search_result'))
        //->setMethod('POST')
        //->add('send', SubmitType::class)
        ->getForm();

        $date = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00',strtotime('+1 day'));
        $now = new \DateTime($date);
        $now2 = new \DateTime($date2);
        
        $form->get('dateDepart')->setData($now);
        $form->get('dateArrivee')->setData($now2);

        $date = $now->format('Y-m-d H:i');
        $date = str_replace (' ', 'T', $date);
        $date2 = $now2->format('Y-m-d H:i');
        $date2 = str_replace (' ', 'T', $date2);

        $form->get('duree')->setData('1 jours ,0 heures ,0 minutes');
        $time1 = date('Y-m-d');
         $dateDepart = $now;
         $dateArrivee = $now2;
         $duree =  '1 jours ,0 heures ,0 minutes';

        $repository = $this->getDoctrine()->getRepository(Disponibilite::class);

        $query2 = $repository->createQueryBuilder('d2')
        ->where('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->orwhere('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->setParameter('date1', $dateDepart)
        ->setParameter('date2', $dateArrivee)
        ->orderBy('d2.dateDebut', 'ASC')
        ->getQuery();
        $disponibilites2 = $query2->getResult();
		
       $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
       $query = $repository2->createQueryBuilder('v')
        ->select()
        ->getQuery();
        $voitures = $query->getResult();
       $disponibilites3 = array();
      
       if ($voitures == null){

       }
       else
       {
        for ($i = 0; $i < sizeof($voitures); $i++) {
            $dispo = true;
            for ($j = 0; $j < sizeof($disponibilites2); $j++){
               
                if ($voitures[$i]->getMatricule() == $disponibilites2[$j]->getRefVoiture()->getMatricule())
                {
                   $dispo = false;
                   $j=sizeof($disponibilites2);
                }
            
                }
       if ($dispo == true and $voitures[$i]->getDisponibilite() == true and $voitures[$i]->getIsEnable() == true )
                {
                   $disponibilites3[]= $voitures[$i];
                }
        
    };
}


        return $this->render('disponibilite/search.html.twig', array(
            'form' => $form->createView(),
            'dateDepart' => $dateDepart,'dateArrivee' => $dateArrivee,
            'date'=> $date, 'date2'=>$date2,
            'duree' => $duree, 'disponibilites3' => $disponibilites3,
            'time1' => $date,
            'time2'=> $date2,
        ));

        
}



public function search2Action(Request $request)
{
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('disponibilite_search_result'))
        ->getForm();
        $time1 = $request->get('form')['dateDepart'];
        $time2 =  $request->get('form')['dateArrivee'];
        $duree =  $request->get('form')['duree'];

        $dateDepart = new \DateTime($time1);
        $dateArrivee = new \DateTime($time2);
        $form->get('dateDepart')->setData($dateDepart);
        $form->get('dateArrivee')->setData($dateArrivee);
        $form->get('duree')->setData($duree);
        $repository = $this->getDoctrine()->getRepository(Disponibilite::class);
        $query2 = $repository->createQueryBuilder('d2')
        ->where('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->orwhere('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->setParameter('date1', $dateDepart)
        ->setParameter('date2', $dateArrivee)
        ->orderBy('d2.dateDebut', 'ASC')
        ->getQuery();
        $disponibilites2 = $query2->getResult();
       $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
       $query = $repository2->createQueryBuilder('v')
        ->select()
        ->getQuery();
        $voitures = $query->getResult();
       $disponibilites3 = array();
      
       if ($voitures == null){

       }
       else
       {
        for ($i = 0; $i < sizeof($voitures); $i++) {
            $dispo = true;
            for ($j = 0; $j < sizeof($disponibilites2); $j++){
                if ($voitures[$i]->getMatricule() == $disponibilites2[$j]->getRefVoiture()->getMatricule())
                {
                   $dispo = false;
                   $j=sizeof($disponibilites2);
                }
            
                }
       if ($dispo == true and $voitures[$i]->getDisponibilite() == true)
                {
                   $disponibilites3[]= $voitures[$i];
                }
        
    };
}
        return $this->render('disponibilite/index2.html.twig', array(
            'form' => $form->createView(),
            'time1' => $time1,'time2' => $time2,
            'duree' => $duree, 'disponibilites' => $disponibilites3,
        ));
}


    /**
     * Lists all disponibilite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $disponibilites = $em->getRepository('LocationBundle:Disponibilite')->findAll();

        return $this->render('disponibilite/index.html.twig', array(
            'disponibilites' => $disponibilites,
        ));
    }

    /**
     * Creates a new disponibilite entity.
     *
     */
    public function newAction(Request $request)
    {
        $disponibilite = new Disponibilite();
        $form = $this->createForm('LV\LocationBundle\Form\DisponibiliteType', $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disponibilite);
            $em->flush();

            return $this->redirectToRoute('disponibilite_show', array('id' => $disponibilite->getId()));
        }

        return $this->render('disponibilite/new.html.twig', array(
            'disponibilite' => $disponibilite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a disponibilite entity.
     *
     */
    public function showAction(Disponibilite $disponibilite)
    {
        $deleteForm = $this->createDeleteForm($disponibilite);

        return $this->render('disponibilite/show.html.twig', array(
            'disponibilite' => $disponibilite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing disponibilite entity.
     *
     */
    public function editAction(Request $request, Disponibilite $disponibilite)
    {
        $deleteForm = $this->createDeleteForm($disponibilite);
        $editForm = $this->createForm('LV\LocationBundle\Form\DisponibiliteType', $disponibilite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disponibilite_edit', array('id' => $disponibilite->getId()));
        }

        return $this->render('disponibilite/edit.html.twig', array(
            'disponibilite' => $disponibilite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a disponibilite entity.
     *
     */
    public function deleteAction(Request $request, Disponibilite $disponibilite)
    {
        $form = $this->createDeleteForm($disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($disponibilite);
            $em->flush();
        }

        return $this->redirectToRoute('disponibilite_index');
    }

    /**
     * Creates a form to delete a disponibilite entity.
     *
     * @param Disponibilite $disponibilite The disponibilite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Disponibilite $disponibilite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('disponibilite_delete', array('id' => $disponibilite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
