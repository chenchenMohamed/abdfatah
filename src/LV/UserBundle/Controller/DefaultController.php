<?php

namespace LV\UserBundle\Controller;

use LV\LocationBundle\Entity\Disponibilite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormView;
use LV\LocationBundle\Entity\Voiture;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }

         public function reserverAction(Request $request)
{
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('reserver_result'))
        //->setMethod('POST')
        //->add('send', SubmitType::class)
        ->getForm();

        $date = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00',strtotime('+1 day'));
        $now = new \DateTime($date);
        $now2 = new\DateTime($date2);
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
       if ($dispo == true)
                {
                   $disponibilites3[]= $voitures[$i];
                }
        
    };
}
      $message ='';


        return $this->render('@User/Default/reservation.html.twig', array(
            'form' => $form->createView(),
            'dateDepart' => $dateDepart,'dateArrivee' => $dateArrivee,
            'date'=> $date, 'date2'=>$date2,
            'duree' => $duree, 'disponibilites3' => $disponibilites3,
            'time1' => $time1,
            'message' => $message,
        ));

        
}



public function reserverResultAction(Request $request)
{
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('reserver_result'))
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
       if ($dispo == true)
                {
                   $disponibilites3[]= $voitures[$i];
                }
        
    };
}
        return $this->render('@User/Default/reservationResult.html.twig', array(
            'form' => $form->createView(),
            'time1' => $time1,'time2' => $time2,
            'duree' => $duree, 'disponibilites' => $disponibilites3,
        ));
}

public function infoAction(Request $request)
{
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        //->add('dateDepart', TextType::class)
        //->add('dateArrivee', TextType::class)
        ->add('duree', TextType::class)
        ->add('voiture', TextType::class)
        ->add('numPermis', TextType::class, array('required' => false))
        ->add('prenom', TextType::class)
        ->add('nom', TextType::class)
        ->add('cin', TextType::class, array('required' => false))
        ->add('telephone', TextType::class)
        ->add('adresse', TextType::class, array('required' => false))
        //->setAction($this->generateUrl('reserver_result'))
        ->getForm();

        $time1 = $_GET['time1'];
        $time2 = $_GET['time2'];
        $result = $_GET['result'];
        $voiture = $_GET['voiture'];

        $time1 = str_replace ('T', ' ', $time1);
        $time2 =  str_replace ('T', ' ', $time2);
        //$form->get('dateDepart')->setData($time1);
        //$form->get('dateArrivee')->setData($time2);
        $form->get('duree')->setData($result);
        $form->get('voiture')->setData($voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $data = $form->getData();
          $msg = "Bonjour,\nVous avez une réservation effectuée de la part de ".$data['prenom']." ".$data['nom']." "."pour la voiture : ".$data['voiture'].".\n"."Date début : ".$time1.".\n"."Date fin : ".$time2.".\n"."Téléphone : ".$data['telephone'].".\n"."CIN : ".$data['cin'].".\n"."Numéro permis : ".$data['numPermis'].".\n" ;

         // use wordwrap() if lines are longer than 70 characters
         $msg = wordwrap($msg,70);

         // send email
         mail("reservation@chaffarrentacar.com","Réservation",$msg);
         if(mail("reservation@chaffarrentacar.com","Réservation",$msg))
         {
          $message = "Demande envoyé avec succès vous pouver effectuer une nouvelle réservation";
           return $this->redirectToRoute('reserversuccess', array(
            'message'=> $message,
          ));
         }else{
         $message = "Email non envoyé !! Essayez de nouveau";
         return $this->redirectToRoute('reserversuccess', array(
            'message'=> $message,));
         }

        }
        
        /*$nom = $request->get('form')['nom'];
        $prenom = $request->get('form')['prenom'];
        $age = $request->get('form')['age'];
        $cin = $request->get('form')['cin'];
        $numPermis = $request->get('form')['numPermis'];
        $adresse = $request->get('form')['adresse'];*/
        
        return $this->render('@User/Default/info.html.twig', array(
            'form' => $form->createView(),
            'time1'=>$time1,
            'time2'=>$time2,
        ));
}

   public function reserverSuccessAction(Request $request)
{
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateTimeType::class,array('input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('reserver_result'))
        //->setMethod('POST')
        //->add('send', SubmitType::class)
        ->getForm();

        $date = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00',strtotime('+1 day'));
        $now = new \DateTime($date);
        $now2 = new\DateTime($date2);
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
       if ($dispo == true)
                {
                   $disponibilites3[]= $voitures[$i];
                }
        
    };
}
      $message = $_GET['message'];


        return $this->render('@User/Default/reservationSuccess.html.twig', array(
            'form' => $form->createView(),
            'dateDepart' => $dateDepart,'dateArrivee' => $dateArrivee,
            'date'=> $date, 'date2'=>$date2,
            'duree' => $duree, 'disponibilites3' => $disponibilites3,
            'time1' => $time1,
            'message' => $message,
        ));

        
}
 public function contactAction(Request $request)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        //->add('dateDepart', TextType::class)
        //->add('dateArrivee', TextType::class)
        ->add('nom', TextType::class)
        ->add('email', EmailType::class, array('required' => false))
        ->add('telephone', TextType::class)
        ->add('mm', TextareaType::class, array('empty_data' => 'Message'))
        //->setAction($this->generateUrl('reserver_result'))
        ->getForm();
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

          $data = $form->getData();
          $msg = "Bonjour,\nVous avez un message de la part de ".$data['nom'].".\n"."Email : ".$data['email'].".\n"."Téléphone : ".$data['telephone'].".\n"."Message : ".$data['message'].".\n" ;

         // use wordwrap() if lines are longer than 70 characters
         $msg = wordwrap($msg,70);

         // send email
         mail("reservation@chaffarrentacar.com","Message",$msg);
         if(mail("reservation@chaffarrentacar.com","Messgae",$msg))
         {
          $message = "Message envoyé avec succès.";
           return $this->redirectToRoute('contactsuccess', array(
            'message'=> $message,));
         }
         else{
         $message = "Message non envoyé !! Essayez de nouveau.";
         return $this->redirectToRoute('contactsuccess', array(
            'message'=> $message,));
         }

        }


        return $this->render('@User/Default/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function contactSuccessAction(Request $request)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        //->add('dateDepart', TextType::class)
        //->add('dateArrivee', TextType::class)
        ->add('nom', TextType::class)
        ->add('email', EmailType::class, array('required' => false))
        ->add('telephone', TextType::class)
        ->add('mm', TextareaType::class, array('empty_data' => 'Message'))
        //->setAction($this->generateUrl('reserver_result'))
        ->getForm();
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

          $data = $form->getData();
          $msg = "Bonjour,\nVous avez un message effectuée de la part de ".$data['nom'].".\n"."Email : ".$data['email'].".\n"."Téléphone : ".$data['telephone'].".\n"."Message : ".$data['message'].".\n" ;

         // use wordwrap() if lines are longer than 70 characters
         $msg = wordwrap($msg,70);

         // send email
         mail("reservation@chaffarrentacar.com","Réservation",$msg);
         if(mail("reservation@chaffarrentacar.com","Réservation",$msg))
         {
          $message = "Message envoyé avec succès.";
           return $this->redirectToRoute('contactsuccess', array(
            'message'=> $message,
          ));
         }else{
         $message = "Message non envoyé !! Essayez de nouveau.";
         return $this->redirectToRoute('contactsuccess', array(
            'message'=> $message,));
         }

        }
         $mm = $_GET['message'];

        return $this->render('@User/Default/contactSuccess.html.twig', array(
            'form' => $form->createView(),
            'message' => $mm,
        ));
    }

    public function accueilClientAction()
    {
    	$em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('LocationBundle:Client')->findAll();
        $contrats = $em->getRepository('LocationBundle:CSR')->findAll();
        $nbreClients = sizeof($clients);
        $nbreContrats = sizeof($contrats);

        $repository = $this->getDoctrine()->getRepository(Voiture::class);

        $query = $repository->createQueryBuilder('v')
        ->select('v')
        ->where('v.etat = :etat1 or v.etat = :etat2')
        ->setParameter('etat1','Location')
        ->setParameter('etat2', '')
        ->getQuery();
        $voitures = $query->getResult();
        $nbreVoitures = sizeof($voitures);
      
        return $this->render('@User/Default/accueilClient.html.twig', array(
        	'voitures' => $voitures,
        	'nbreVoitures' => $nbreVoitures,
        	'nbreClients' => $nbreClients,
        	'nbreContrats' => $nbreContrats,
        ));
    }
    public function voituresAction()
    {
    	$em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(Voiture::class);

        $query = $repository->createQueryBuilder('v')
        ->select('v')
        ->where('v.etat = :etat1 or v.etat = :etat2')
        ->setParameter('etat1','Location')
        ->setParameter('etat2', '')
        ->getQuery();
        $voitures = $query->getResult();
        $nbreVoitures = sizeof($voitures);
      
        return $this->render('@User/Default/voitures.html.twig', array(
        	'voitures' => $voitures,
        	'nbreVoitures' => $nbreVoitures,
        ));
    }
}
