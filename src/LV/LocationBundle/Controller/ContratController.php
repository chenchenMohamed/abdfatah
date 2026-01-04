<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Contrat;
use LV\LocationBundle\Entity\CSR;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\LocationBundle\Entity\Disponibilite;
use LV\LocationBundle\Entity\Reservation;
use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Paiement;
use LV\LocationBundle\Entity\Client;

/**
 * Contrat controller.
 *
 */
class ContratController extends Controller
{
    /**
     * Lists all contrat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contrats = $em->getRepository('LocationBundle:Contrat')->findAll();
        $csrs = $em->getRepository('LocationBundle:CSR')->findAll();
        $paiements = $em->getRepository('LocationBundle:Paiement')->findAll();
        $retours = $em->getRepository('LocationBundle:Retour')->findAll();
 
        return $this->render('contrat/index.html.twig', array(
            'contrats' => $contrats,
            'cSRs' => $csrs,
            'paiements' => $paiements,
            'retours' => $retours,
        ));
    }

    /**
     * Creates a new contrat entity.
     *
     */
    public function newAction(Request $request)
    {
        $contrat = new Contrat();
        $form = $this->createForm('LV\LocationBundle\Form\ContratType', $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contrat);
            $em->flush();
            
            return $this->redirectToRoute('contrat_show', array('id' => $contrat->getId()));
        }

        return $this->render('contrat/new.html.twig', array(
            'contrat' => $contrat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new contrat entity.
     *
     */
    public function new1Action(Request $request, $id)
    {
        $contrat = new Csr();
        $client = new Client();
        $client2 = new Client();
       
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Reservation');
        $r = $objectsRepository->findOneById($id);
        
        $time1 = $r->getDateDebut();
        $time1 = $time1->format('Y-m-d H:i');
        $time1 = str_replace (' ', 'T', $time1);
        $time2 = $r->getDateFin();
        $time2 = $time2->format('Y-m-d H:i');
        $time2 = str_replace (' ', 'T', $time2);

        $refClient = $r->getRefClient();
        $refVoiture = $r->getRefVoiture();
        $dd=$r->getDateDebut();
        $df=$r->getDateFin();
        $prix = $refVoiture->getPrix();
        $modele =  $refVoiture->getModele();
        $marque = $refVoiture->getMarque();
        $couleur = $refVoiture->getCouleur();
        $prix = $refVoiture->getPrix();
        //var_dump($prix);
        $nom = $refClient->getNom();
        $prenom = $refClient->getPrenom();
        $dateNaissance = $refClient->getDateNaissance();
        $cin = $refClient->getCin();
        $numPermis = $refClient->getNumPermis();
        $delivre = $refClient->getDelivre();
        $nationalite = $refClient->getNationalite();
        $adresse = $refClient->getAdresse();
        $contrat->setRefReservation($r);
        $contrat->setConducteur1($refClient);
        $contrat->setRefVoiture($refVoiture);
        $contrat->setDegats(false);
        //$contrat->setConducteur2($refClient);
        
        $duree = $r->getNbreJour();
        $contrat->setTarif($prix);
        $contrat->setNbreJour($duree);
        $temp = explode ( ' ', $duree); 
        $recette = $contrat->getTarif()*$temp[0]; 
        $contrat->setRecette($recette);
        $contrat->setTotalHTVA($recette);
        $TVA = (19*$recette)/100; 
        $contrat->setTVA($TVA);
        $contrat->setSousTotal($recette+$TVA);
        $timbre = 1.000;
        $contrat->setTimbre($timbre);
        $contrat->setTotal($recette+$TVA+$timbre);


        $contrat->setKmDepart($refVoiture->getKm());
        $dateDebut = $r->getDateDebut();
        $dateFin = $r->getDateFin();
        $matricule = $refVoiture->getMatricule();
        $id_matricule = $refVoiture->getId();
        $em1 = $this->getDoctrine()->getManager();
        $voitures = $em1->getRepository('LocationBundle:Voiture')->findAll();
        // id new contrat
         $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Contrat::class)->findOneBy(array(), array('id' => 'desc'));
            $csr = $em2->getRepository(CSR::class)->findOneBy(array(), array('id' => 'desc'));
            
            $year = date('Y');
            $datesys = (int) $year;
               if ($c == null and $csr == null){
                $num='1'."/".$year;
                $contrat->setNumContrat($num);  
                }
               
                elseif($c == null and $csr != null){
                $numcsr = substr($csr->getNumContrat(), (strlen($csr->getNumContrat())-4), strlen($csr->getNumContrat()));
                $csrid = explode('/', $csr->getNumContrat());
                $csrid = (int) $csrid[0];
                $numcsr = (int) $numcsr;
                if($datesys>$numcsr)
                {
                $num='1'."/".$datesys;
                $contrat->setNumContrat($num);  

                }else
                {
                $num=($csrid+1)."/".$datesys;
                $contrat->setNumContrat($num);  
                }
                }

                elseif($c != null and $csr == null){
                $numc = substr($c->getNumContrat(), (strlen($c->getNumContrat())-4), strlen($c->getNumContrat()));
                $cid = explode('/', $c->getNumContrat());
                $cid = (int) $cid[0];
                $numc = (int) $numc;
                if($datesys>$numc)
                {
                $num='1'."/".$datesys;
                $contrat->setNumContrat($num);  

                }else
                {
                $num=($cid+1)."/".$datesys;
                $contrat->setNumContrat($num);  
                }
                }

                else{
                $numc = substr($c->getNumContrat(), (strlen($c->getNumContrat())-4), strlen($c->getNumContrat()));
                $cid = explode('/', $c->getNumContrat());
                $cid = (int) $cid[0];
                $numc = (int) $numc;
                $numcsr = substr($csr->getNumContrat(), (strlen($csr->getNumContrat())-4), strlen($csr->getNumContrat()));
                $csrid = explode('/', $csr->getNumContrat());
                $csrid = (int) $csrid[0];
                $numcsr = (int) $numcsr;
                if($numc>$numcsr){ $date = $numc;}
                else{$date = $numcsr;}
                if($cid>$csrid){$numContrat = $cid;}
                else{$numContrat = $csrid;}
                if($datesys>$date)
                {
                $num='1'."/".$datesys;
                $contrat->setNumContrat($num);  

                }else
                {
                $num=($numContrat+1)."/".$datesys;
                $contrat->setNumContrat($num);  
                }
            }
            $form2 = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
         $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

         $contrat->setConducteur2($client);
        };

        $clients = $em1->getRepository('LocationBundle:Client')->findAll();
          
        $form = $this->createForm('LV\LocationBundle\Form\CSRType', $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $rep= $this->getDoctrine()->getManager();
            $rep2 = $rep->getRepository(Disponibilite::class);
       $res = $rep2->createQueryBuilder('d')
             ->update()
             ->set('d.etat',':louee')
             ->where('d.dateDebut = :date1 and d.dateFin = :date2 and d.refVoiture = :id_matricule')
             ->setParameter('louee', 'Louée')
             ->setParameter('date1', $dateDebut)
             ->setParameter('date2', $dateFin)
             ->setParameter('id_matricule', $id_matricule)
             ->getQuery()
            ->execute();
        

            $em = $this->getDoctrine()->getManager();
            $em->persist($contrat);
            $em->flush();

            return $this->redirectToRoute('csr_index');
        }

        return $this->render('csr/new2.html.twig', array(
            'cSR' => $contrat,
            'clients' => $clients,
            'voitures' => $voitures,
            'form' => $form->createView(),
            'form_client' => $form2->createView(),
            'refClient' => $refClient,
            'matricule' => $matricule,
            'modele' =>$modele,
            'couleur' => $couleur,
            'marque' => $marque,
            'prix' => $prix,
            'cin' => $cin,
            'nom' => $nom,
            'dateNaissance' => $dateNaissance,
            'prenom' => $prenom,
            'numPermis' => $numPermis,
            'delivre' => $delivre,
            'nationalite' => $nationalite,
            'duree' => $duree,
            'dd' => $dd,
            'df' => $df,
            'time1'=> $time1,
            'time2' => $time2,
            'adresse' => $adresse,
            'client' => $client,

        ));
    }

    /**
     * Finds and displays a contrat entity.
     *
     */
    public function showAction(Contrat $contrat)
    {
        $deleteForm = $this->createDeleteForm($contrat);

        return $this->render('contrat/show.html.twig', array(
            'contrat' => $contrat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contrat entity.
     *
     */
    public function editAction(Request $request, Contrat $contrat)
    {
        $deleteForm = $this->createDeleteForm($contrat);
        $editForm = $this->createForm('LV\LocationBundle\Form\ContratType', $contrat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('csr_index', array('id' => $contrat->getId()));
        }

        return $this->render('contrat/edit.html.twig', array(
            'contrat' => $contrat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contrat entity.
     *
     */
     public function deleteAction(Request $request, Contrat $contrat)
    {    $em= $this->getDoctrine()->getManager();
         $objectsRepository = $em->getRepository('LocationBundle:Contrat');
         $r = $objectsRepository->findOneById($contrat->getId());
        $form = $this->createDeleteForm($contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
		 $dateDebut=$contrat->getRefReservation()->getDateDebut();
		 $dateFin=$contrat->getRefReservation()->getDateFin();
		 $id_matricule=$contrat->getRefReservation()->getRefVoiture()->getId();
			$rep2 = $em->getRepository(Disponibilite::class);
            $res = $rep2->createQueryBuilder('d')
             ->delete()
             ->where('d.dateDebut = :date1 and d.dateFin = :date2 and d.refVoiture = :id_matricule')
             ->setParameter('date1', $dateDebut)
             ->setParameter('date2', $dateFin)
             ->setParameter('id_matricule', $id_matricule)
             ->getQuery()
            ->execute();
			$sup = $em->getRepository(Reservation::class);
            $sup2 = $sup->createQueryBuilder('s')
             ->delete()
             ->where('s.dateDebut = :date1 and s.dateFin = :date2 and s.refVoiture = :id_matricule')
             ->setParameter('date1', $dateDebut)
             ->setParameter('date2', $dateFin)
             ->setParameter('id_matricule', $id_matricule)
             ->getQuery()
            ->execute();
            $em->remove($contrat);
            $em->flush();
        }

        return $this->redirectToRoute('csr_index');
    }

    /**
     * Creates a form to delete a contrat entity.
     *
     * @param Contrat $contrat The contrat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contrat $contrat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contrat_delete', array('id' => $contrat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }/*
public function edit1Action(Request $request,Contrat $contrat)
    { $p =$this->getDoctrine()->getRepository('LocationBundle:Contrat')->findOneById($contrat->getId());
   // var_dump($p->getId());
        $deleteForm = $this->createDeleteForm($paiement); 
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementType', $p->getId());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_edit', array('id' => $paiement->getId()));
        }

        return $this->render('paiement/edit.html.twig', array(
            'paiement' => $paiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }*/



}
