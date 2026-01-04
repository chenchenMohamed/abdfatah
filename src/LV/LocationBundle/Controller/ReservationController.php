<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Reservation;
use Symfony\Component\Form\FormView;
use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Disponibilite;
use LV\LocationBundle\Entity\Contrat;
use LV\LocationBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\Form\Forms;

/** 
 * Reservation controller.
 *
 */
class ReservationController extends Controller
{/*
	public function newClientAction(Request $request) {
         $client = new Client();
         $form3 = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
         $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
        }

        return $this->render('reservation/new1.html.twig', array(
            'client' => $client,
            'form3' => $form3->createView(),
        ));
    }*/
    
    /**
     * Lists all reservation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('LocationBundle:Reservation')->findAll();
        $voitures = $em2->getRepository('LocationBundle:Voiture')->findAll();
        $contrats = $em2->getRepository('LocationBundle:CSR')->findAll();
       
        return $this->render('reservation/index.html.twig', array(
            'reservations' => $reservations,
            'voitures' => $voitures,
            'contrats' => $contrats,
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     */
    public function newAction(Request $request)
    {
         $reservation = new Reservation();
         $form = $this->createForm('LV\LocationBundle\Form\ReservationType', $reservation);
         $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            return $this->redirectToRoute('reservation_show', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     */
    public function new1Action(Request $request, $time1, $time2, $result, $voiture)
    {   
        $reservation = new Reservation();
        $disponibilite = new Disponibilite();
        $client = new Client();
        $client->setDisponibilite(true);
        $client->setCause(' ');
        $dateDepart = str_replace ( 'T', ' ', $time1);
        $dateArrivee = str_replace ( 'T', ' ', $time2);
        $duree = $result;
           
         $em1= $this->getDoctrine()->getManager();
         $objectsRepository = $em1->getRepository('LocationBundle:Voiture');
         $v = $objectsRepository->findOneByMatricule($voiture);       
            $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Reservation::class)->findOneBy(array(), array('id' => 'desc'));
            $date = date('Y');
            if ($c == null)
            {
              $num='1'."/".$date;
              $reservation->setNumReservation($num);  
            }
            else
            {   
                $res = substr($c->getNumReservation(), (strlen($c->getNumReservation())-4), strlen($c->getNumReservation()));
                $res = (int) $res;
                $date1 = (int) $date;
                if($date1>$res)
                {
                $cid=$c->getId();
                $num=($cid-($cid-1))."/".$date;
                $reservation->setNumReservation($num);  

                }else
                {
                $cid=$c->getId();
                $num=($cid+1)."/".$date;
                $reservation->setNumReservation($num);  
                };
               
            };
         $aa = new \DateTime($dateDepart);
         $bb = new \DateTime($dateArrivee);
         $tz = new \DateTimeZone('Europe/London');
         $now = new \DateTime('NOW', $tz);
       
         $reservation->setDateResevation($now);
      //   var_dump($reservation->setDateResevation($now));
         $reservation->setDateDebut($aa);
         $reservation->setDateFin($bb);
         $reservation->setNbreJour($duree);
         $reservation->setRefVoiture($v);
         $disponibilite->setRefVoiture($v);
         $disponibilite->setDateDebut($aa);
         $reservation->setDateDebut($aa);
         $disponibilite->setDateFin($bb);
         $disponibilite->setEtat('Réservée');

         $form2 = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
         $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

           $reservation->setRefClient($client);
            
        }


         $form = $this->createForm('LV\LocationBundle\Form\ReservationType', $reservation);
         $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $disponibilite->setRefClient($reservation->getRefClient());
            $em->persist($disponibilite);
            $em->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/new1.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
            'form_client' => $form2->createView(),
            'voiture'=>$voiture,
            'num'=> $num,
            'time1'=> $time1,
            'time2' => $time2,          
                    ));
    }

    /**
     * Finds and displays a reservation entity.
     *
     */
    public function showAction(Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);

        return $this->render('reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     */
    public function editAction(Request $request, Reservation $reservation)
    {
        $voiture=$reservation->getRefVoiture()->getMatricule();
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime('NOW', $tz);
        $reservation->setDateResevation($now);
	    $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('LV\LocationBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);
        
        $time1 = $reservation->getDateDebut();
        $time1 = $time1->format('Y-m-d H:i');
        $time1 = str_replace (' ', 'T', $time1);
        $time2 = $reservation->getDateFin();
        $time2 = $time2->format('Y-m-d H:i');
        $time2 = str_replace (' ', 'T', $time2);

        $dateDebut = $request->get('lv_locationbundle_reservation')['dateDebut'];
        $dateFin = $request->get('lv_locationbundle_reservation')['dateFin'];
        $errors = '';

        $repository = $this->getDoctrine()->getRepository(Disponibilite::class);
        $query = $repository->createQueryBuilder('m')
        ->where('m.dateDebut >= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin >= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->orwhere('m.dateDebut <= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin >= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->orwhere('m.dateDebut <= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin <= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->orwhere('m.dateDebut >= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin <= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->setParameter('date1', $dateDebut)
        ->setParameter('date2', $dateFin)
        ->setParameter('vehicule', $reservation->getRefVoiture())
        ->setParameter('client', $reservation->getRefClient())
        ->orderBy('m.dateFin', 'DESC')
        ->getQuery();
        $disponibilites = $query->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($disponibilites == null){

            $em = $this->getDoctrine()->getManager();
            $query3 = $em->getRepository(Disponibilite::class)->createQueryBuilder('')
            ->update(disponibilite::class, 'v')
            ->set('v.dateFin', ':dateArrivee')
            ->set('v.dateDebut', ':dateDepart')
            ->where('v.refVoiture = :refVoiture and v.dateDebut = :dateDebut and v.dateFin = :dateFin')
            ->setParameter('dateArrivee', $dateFin)
            ->setParameter('dateDepart', $dateDebut)
            ->setParameter('refVoiture', $reservation->getRefVoiture())
            ->setParameter('dateDebut', $reservation->getDateDebut())
            ->setParameter('dateFin', $reservation->getDateFin())
            ->getQuery();
            $result3 = $query3->execute();
            $this->getDoctrine()->getManager()->flush();
            }
            else{
                $errors = 'Dates invalides : cette voiture est '.$disponibilites[0]->getEtat().' par le client '.$disponibilites[0]->getRefClient()->getPrenom().' '.$disponibilites[0]->getRefClient()->getNom();

            return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'voiture' => $voiture,
            'time1' => $time1,
            'time2' => $time2,
            'errors' => $errors,
        ));
            }
            

            return $this->redirectToRoute('reservation_index', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'voiture' => $voiture,
            'time1' => $time1,
            'time2' => $time2,
            'errors' => $errors,
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     */
    public function deleteAction(Request $request, Reservation $reservation)
    {    $em= $this->getDoctrine()->getManager();
         $objectsRepository = $em->getRepository('LocationBundle:Reservation');
         $r = $objectsRepository->findOneById($reservation->getId());
        $form = $this->createDeleteForm($reservation);
        $form->handleRequest($request);

        
            $em = $this->getDoctrine()->getManager();
		 $dateDebut=$reservation->getDateDebut();
		 $dateFin=$reservation->getDateFin();
		 $id_matricule=$reservation->getRefVoiture()->getId();
			$rep2 = $em->getRepository(Disponibilite::class);
            $res = $rep2->createQueryBuilder('d')
             ->delete()
             ->where('d.dateDebut = :date1 and d.dateFin = :date2 and d.refVoiture = :id_matricule')
             ->setParameter('date1', $dateDebut)
             ->setParameter('date2', $dateFin)
             ->setParameter('id_matricule', $id_matricule)
             ->getQuery()
            ->execute();
            $em->remove($reservation);
            $em->flush();
        

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
