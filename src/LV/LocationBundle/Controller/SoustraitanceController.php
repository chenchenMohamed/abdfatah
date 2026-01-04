<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Soustraitance;
use LV\LocationBundle\Entity\PaiementSoustraitance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Disponibilite;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Soustraitance controller.
 *
 */
class SoustraitanceController extends Controller
{
        

        public function searchAction(Request $request)
        {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateType::class,array('data'=>new \DateTime(),'input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateType::class,array('data'=>new \DateTime(),'input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('soustraitance_search_result'))
        ->getForm();

        $date = date('Y-m-d');
        $now = new \DateTime($date);
        $form->get('dateDepart')->setData($now);
        $form->get('dateArrivee')->setData($now);
        $form->get('duree')->setData('1 jours ,0 heures ,0 minutes');
        $time1 = date('Y-m-d');
        $dateDepart = $now;
        $dateArrivee = $now;
        $duree =  '1 jours ,0 heures ,0 minutes';

        /*$repository = $this->getDoctrine()->getRepository(Disponibilite::class);

        $query2 = $repository->createQueryBuilder('d2')
        ->where('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->orwhere('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->setParameter('date1', $dateDepart)
        ->setParameter('date2', $dateArrivee)
        ->orderBy('d2.dateDebut', 'ASC')
        ->getQuery();
        $disponibilites2 = $query2->getResult();*/
        
       $repository = $this->getDoctrine()->getRepository(Voiture::class);
       $query = $repository->createQueryBuilder('v')
        ->select('v')
        ->where('v.etat = :etat AND NOT EXISTS (SELECT s FROM LV\LocationBundle\Entity\Soustraitance s WHERE v = s.refVoiture)')
        ->setParameter('etat', 'Soustraitance')
        ->getQuery();
        $voitures = $query->getResult();
      /* $disponibilites3 = array();
      
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
}*/


        return $this->render('soustraitance/search.html.twig', array(
            'form' => $form->createView(),
            'dateDepart' => $dateDepart,'dateArrivee' => $dateArrivee,
            'duree' => $duree, 'disponibilites3' => $voitures,
            'time1' => $time1,
        ));

        
}



public function search2Action(Request $request)
        {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dateDepart', DateType::class,array('data'=>new \DateTime(),'input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->add('dateArrivee', DateType::class,array('data'=>new \DateTime(),'input' => 'datetime','widget' => 'single_text','attr' => array('class' => 'calendar')))
        ->add('duree', TextType::class)
        ->setAction($this->generateUrl('soustraitance_search_result'))
        ->getForm();
        $time1 = $request->get('form')['dateDepart'];
        $time2 =  $request->get('form')['dateArrivee'];
        $duree =  $request->get('form')['duree'];
        $dateDepart = new \DateTime($time1);
        $dateArrivee = new \DateTime($time2);
        $form->get('dateDepart')->setData($dateDepart);
        $form->get('dateArrivee')->setData($dateArrivee);
        $form->get('duree')->setData($duree);
        /*$repository = $this->getDoctrine()->getRepository(Disponibilite::class);
        $query2 = $repository->createQueryBuilder('d2')
        ->where('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->orwhere('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->setParameter('date1', $dateDepart)
        ->setParameter('date2', $dateArrivee)
        ->orderBy('d2.dateDebut', 'ASC')
        ->getQuery();
        $disponibilites2 = $query2->getResult();*/
       $repository = $this->getDoctrine()->getRepository(Voiture::class);
       $query = $repository->createQueryBuilder('v')
        ->select()
        ->where('v.etat = :etat AND NOT EXISTS (SELECT s FROM LV\LocationBundle\Entity\Soustraitance s WHERE v = s.refVoiture)')
        ->setParameter('etat', 'Soustraitance')
        ->getQuery();
        $voitures = $query->getResult();
       /*$disponibilites3 = array();
      
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
}*/
        return $this->render('soustraitance/index2.html.twig', array(
            'form' => $form->createView(),
            'time1' => $time1,'time2' => $time2,
            'duree' => $duree, 'disponibilites' => $voitures,
        ));
}


    /**
     * Lists all soustraitance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $soustraitances = $em->getRepository('LocationBundle:Soustraitance')->findAll();

        return $this->render('soustraitance/index.html.twig', array(
            'soustraitances' => $soustraitances,
        ));
    }

    /**
     * Creates a new soustraitance entity.
     *
     */
	     public function newAction(Request $request, $voiture)
    {
        $em = $this->getDoctrine()->getManager();
        $soustraitance = new Soustraitance();
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime();
        $soustraitance->setDatePremierPay($now);
        //$disponibilite = new Disponibilite();
        //$tz = new \DateTimeZone('Europe/London');
        //$now = new \DateTime();
        $v = $em->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);
        $soustraitance->setRefVoiture($v);
        //$soustraitance->setDatePremierPay(new \DateTime($time1));
        //$soustraitance->setDateDernierPay(new \DateTime($time2));
        //sscanf($time1, "%4s-%2s-%2s", $annee, $mois, $jour);
        //$a1 = $annee;
        //$m1 = $mois;
        //sscanf($time2, "%4s-%2s-%2s", $annee, $mois, $jour);
        //$a2 = $annee;
        //$m2 = $mois;

        //$dif_en_mois = ($m2-$m1)+12*($a2-$a1)+1;
        //$soustraitance->setNbrePayRestant($dif_en_mois);
        $soustraitance->setMontantPaye(0);
        $soustraitance->setEtat('Non payé');
        

        /*$disponibilite->setRefVoiture($v);
        $disponibilite->setDateDebut(new \DateTime($time1));
        $disponibilite->setDateFin(new \DateTime($time2));
        $disponibilite->setEtat('Louée');*/

        $form = $this->createForm('LV\LocationBundle\Form\SoustraitanceType', $soustraitance);
        $form->handleRequest($request);
        /*$mat=$request->get('lv_locationbundle_soustraitance')['refVoiture'];
        $debut=$request->get('lv_locationbundle_soustraitance')['datePremierPay'];
        $fin=$request->get('lv_locationbundle_soustraitance')['dateDernierPay'];*/
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($soustraitance);
            //$em->persist($disponibilite);
            
            $em->flush();

            return $this->redirectToRoute('soustraitance_index', array('id' => $soustraitance->getId()));
        }

        return $this->render('soustraitance/new.html.twig', array(
            'soustraitance' => $soustraitance,
            'form' => $form->createView(),
			'matricule'=>$voiture,
        ));
    }
  /*  public function newAction(Request $request)
    {
        $soustraitance = new Soustraitance();
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime();
        $soustraitance->setDatePremierPay($now);
        $form = $this->createForm('LV\LocationBundle\Form\SoustraitanceType', $soustraitance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($soustraitance);
            $em->flush();

            return $this->redirectToRoute('soustraitance_show', array('id' => $soustraitance->getId()));
        }

        return $this->render('soustraitance/new.html.twig', array(
            'soustraitance' => $soustraitance,
            'form' => $form->createView(),
        ));
    }*/




    public function detailAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();


        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Soustraitance');
        $soustraitance = $objectsRepository->findOneById($id);
        $aa = $soustraitance->getDatePremierPay();
        $bb = $soustraitance->getDateDernierPay();
        $start = $aa->format('Y-m-d');
        $end = $bb->format('Y-m-d');
        sscanf($start, "%4s-%2s-%2s", $annee, $mois, $jour);
        $a1 = $annee;
        $m1 = $mois;
        sscanf($end, "%4s-%2s-%2s", $annee, $mois, $jour);
        $a2 = $annee;
        $m2 = $mois;

        $dif_en_mois = ($m2-$m1)+12*($a2-$a1)+1;

        $PaiementSoustraitances = $em->getRepository('LocationBundle:PaiementSoustraitance')->findAll();

        
       
        $repository = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        $query = $repository->createQueryBuilder('d')
        ->where('d.refSoustraitance = :id')
        ->setParameter('id', $id)
        ->orderBy('d.date', 'DESC')
        ->setMaxResults(1)
        ->getQuery();
        $ech = $query->getResult();
        if($ech == null){
               $dt = '';
       }
       else{
        $dt = $ech[0]->getDate();
    }


        return $this->render('soustraitance/detail.html.twig', array(
            'soustraitance' => $soustraitance,
            'dif_en_mois' => $dif_en_mois,
            'paiementSoustraitances' => $PaiementSoustraitances,
            'dt' => $dt,
        ));
    }

    /**
     * Finds and displays a soustraitance entity.
     *
     */
    public function showAction(Soustraitance $soustraitance)
    {
        $deleteForm = $this->createDeleteForm($soustraitance);

        return $this->render('soustraitance/show.html.twig', array(
            'soustraitance' => $soustraitance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing soustraitance entity.
     *
     */
    public function editAction(Request $request, Soustraitance $soustraitance)
    {
        $voiture = $soustraitance->getRefVoiture()->getMatricule();
        $datePremierPay = $soustraitance->getDatePremierPay();
        $dateDernierPay = $soustraitance->getDateDernierPay();
        $deleteForm = $this->createDeleteForm($soustraitance);
        $editForm = $this->createForm('LV\LocationBundle\Form\SoustraitanceType', $soustraitance);
        $editForm->handleRequest($request);
//var_dump($soustraitance->getRefVoiture());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('soustraitance_index', array('id' => $soustraitance->getId()));
        }
 
        return $this->render('soustraitance/edit.html.twig', array(
            'soustraitance' => $soustraitance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'voiture' => $voiture,
            'datePremierPay' => $datePremierPay,
            'dateDernierPay' => $dateDernierPay,
        ));
    }

    /**
     * Deletes a soustraitance entity.
     *
     */
    public function deleteAction(Request $request, Soustraitance $soustraitance)
    {
        $form = $this->createDeleteForm($soustraitance);
        $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->remove($soustraitance);
            $em->flush();
        

        return $this->redirectToRoute('soustraitance_index');
    }

    /**
     * Creates a form to delete a soustraitance entity.
     *
     * @param Soustraitance $soustraitance The soustraitance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Soustraitance $soustraitance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('soustraitance_delete', array('id' => $soustraitance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
