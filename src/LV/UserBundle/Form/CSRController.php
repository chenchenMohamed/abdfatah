<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\CSR;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use LV\LocationBundle\Entity\Disponibilite;
use LV\LocationBundle\Entity\Reservation;
use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Contrat;
use LV\LocationBundle\Entity\Client;
//use LV\LocationBundle\Entity\Client;
//use LV\LocationBundle\Form\ClientForm;

/**
 * Csr controller.
 *
 */
class CSRController extends Controller
{

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
    }

    /**
     * Lists all cSR entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cSRs = $em->getRepository('LocationBundle:CSR')->findAll();
        $contrats = $em->getRepository('LocationBundle:Contrat')->findAll();
        $em = $this->getDoctrine()->getManager();
        
        if($cSRs == null){
             $query = $em->createQuery("SELECT c FROM LV\LocationBundle\Entity\Contrat c ORDER BY c.numContrat DESC");
            $results = $query->getResult();
        }
        else if($contrats == null){
             $query = $em->createQuery("SELECT csr FROM LV\LocationBundle\Entity\CSR csr ORDER BY csr.numContrat DESC");
            $results = $query->getResult();
        }
        else{ 
        $query = $em->createQuery("SELECT csr,c FROM LV\LocationBundle\Entity\CSR csr, LV\LocationBundle\Entity\Contrat c ORDER BY c.numContrat DESC, csr.numContrat DESC");
            $results = $query->getResult();}

        $paiements = $em->getRepository('LocationBundle:Paiement')->findAll();
        $retours = $em->getRepository('LocationBundle:Retour')->findAll();
        //var_dump($results);
        return $this->render('csr/index.html.twig', array(
            'cSRs' => $cSRs,
            'contrats' => $contrats,
            'paiements' => $paiements,
            'retours' => $retours,
            'results' => $results,
        ));
    }

     /**
     * Creates a new cSR entity.
     *
     */
     public function new1Action(Request $request,$time1,$time2,$result,$voiture)
    {  
        $cSR = new Csr();
        $client = new Client();
        $client2 = new Client();
        $disponibilite = new Disponibilite();
        $d1 = str_replace ( 'T', ' ', $time1);
        $f1 = str_replace ( 'T', ' ', $time2);
        $cSR->setDateDebut(new \DateTime($d1));
        $cSR->setDateFin(new \DateTime($f1));
        $em1 = $this->getDoctrine()->getManager();
        $v = $em1->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);
        $cSR->setRefVoiture($v);
        $clients = $em1->getRepository('LocationBundle:Client')->findAll();
        $voitures = $em1->getRepository('LocationBundle:Voiture')->findAll();
		$matricule=$v->getMatricule();
		$couleur=$v->getCouleur();
		$marque=$v->getMarque();
		$modele=$v->getModele();
		$prix=$v->getprix();
        $cSR->setKmDepart($v->getKm());
		$cSR->setNbreJour($result);
		$cSR->setTarif($prix);
		$total = (Int)$result * $prix;
		$cSR->setRecette($total);
            $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Contrat::class)->findOneBy(array(), array('id' => 'desc'));
            $csr = $em2->getRepository(CSR::class)->findOneBy(array(), array('id' => 'desc'));
            
            $year = date('Y');
            $datesys = (int) $year;
               if ($c == null and $csr == null){
                $num='1'."/".$year;
                $cSR->setNumContrat($num);  
                }
               
                elseif($c == null and $csr != null){
                $numcsr = substr($csr->getNumContrat(), (strlen($csr->getNumContrat())-4), strlen($csr->getNumContrat()));
                $csrid = explode('/', $csr->getNumContrat());
                $csrid = (int) $csrid[0];
                $numcsr = (int) $numcsr;
                if($datesys>$numcsr)
                {
                $num='1'."/".$datesys;
                $cSR->setNumContrat($num);  

                }else
                {
                $num=($csrid+1)."/".$datesys;
                $cSR->setNumContrat($num);  
                };
                }

                elseif($c != null and $csr == null){
                $numc = substr($c->getNumContrat(), (strlen($c->getNumContrat())-4), strlen($c->getNumContrat()));
                $cid = explode('/', $c->getNumContrat());
                $cid = (int) $cid[0];
                $numc = (int) $numc;
                if($datesys>$numc)
                {
                $num='1'."/".$datesys;
                $cSR->setNumContrat($num);  

                }else
                {
                $num=($cid+1)."/".$datesys;
                $cSR->setNumContrat($num);  
                };
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
                else{$date = $numcsr;};
                if($cid>$csrid){$numContrat = $cid;}
                else{$numContrat = $csrid;};
                if($datesys>$date)
                {
                $num='1'."/".$datesys;
                $cSR->setNumContrat($num);  

                }else
                {
                $num=($numContrat+1)."/".$datesys;
                $cSR->setNumContrat($num);  
                };
            };    
        $dd = $request->get('lv_locationbundle_csr')['dateDebut'];
        $df = $request->get('lv_locationbundle_csr')['dateFin'];
     //   $matricule = dump($request->request->get('lv_locationbundle_csr')['refVoiture']);
        //$veh = $em1->getRepository(Voiture::class)->findOneById($matricule);
        $disponibilite->setDateDebut(new \DateTime($dd));
        $disponibilite->setDateFin(new \DateTime($df));        
        $disponibilite->setRefVoiture($v);
        $disponibilite->setEtat('Louée');

         $form2 = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
         $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

         $cSR->setConducteur1($client);
        }
/*
        $form3 = $this->createForm('LV\LocationBundle\Form\ClientType', $client2);
         $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            
            $em2 = $this->getDoctrine()->getManager();
            $em2->persist($client2);
            $em2->flush();

         $cSR->setConducteur2($client2);
            
        }
        */
        $form = $this->createForm('LV\LocationBundle\Form\CSRType', $cSR);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disponibilite);
            $em->persist($cSR);
            $em->flush();

            return $this->redirectToRoute('csr_index');
        }

        return $this->render('csr/new1.html.twig', array(
            'cSR' => $cSR,
            'form' => $form->createView(),
            'form_client' => $form2->createView(),
      //      'form_client2' => $form3->createView(),
            'clients' => $clients,
            'voitures' => $voitures,
		    'matricule' => $matricule,
		    'couleur' => $couleur,
		    'marque' => $marque,
		    'modele' => $modele,
		    'prix' => $prix,
        ));
    }

    public function newAction(Request $request)
    {
        $cSR = new Csr();
        $disponibilite = new Disponibilite();
        $form = $this->createForm('LV\LocationBundle\Form\CSRType', $cSR);
        $form->handleRequest($request);
        $em1 = $this->getDoctrine()->getManager();
        $clients = $em1->getRepository('LocationBundle:Client')->findAll();
        $voitures = $em1->getRepository('LocationBundle:Voiture')->findAll();
        $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(CSR::class)->findOneBy(array(), array('id' => 'desc'));
            $datec = date('Y');
            if ($c == null)
            {
              $cnum='1'."/".$datec;
              $cSR->setNumContrat($cnum);   
            }
            else
            {   
                $resc = substr($c->getNumContrat(), 3, 4);
                $resc = (int) $resc;
                $date1c = (int) $datec;
                if($date1c>$resc)
                {
                $cid=$c->getId();
                $cnum=($cid-($cid-1))."/".$datec;
                $cSR->setNumContrat($cnum);  
                }else
                {
                $cid=$c->getId();
                $cnum=($cid+1)."/".$datec;
                $cSR->setNumContrat($cnum);  
                };
               
            };     
       $dd = $request->get('lv_locationbundle_csr')['dateDebut'];
       $df = $request->get('lv_locationbundle_csr')['dateFin'];
       $matricule = $request->get('lv_locationbundle_csr')['refVoiture'];
        $em3= $this->getDoctrine()->getManager();
       $veh = $em3->getRepository(Voiture::class)->findOneById($matricule);
        $disponibilite->setDateDebut(new \DateTime($dd));
        $disponibilite->setDateFin(new \DateTime($df));        
        $disponibilite->setRefVoiture($veh);
        $disponibilite->setEtat('Louée');
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disponibilite);
            $em->persist($cSR);
            $em->flush();

            return $this->redirectToRoute('csr_show', array('id' => $cSR->getId()));
        }

        return $this->render('csr/new.html.twig', array(
            'cSR' => $cSR,
            'form' => $form->createView(),
        //    'contrats' => $contrats,
            'clients' => $clients,
            'voitures' => $voitures,
            'cnum' => $cnum,
        ));
    }

    /**
     * Finds and displays a cSR entity.
     *
     */
    public function showAction(CSR $cSR)
    {
        $deleteForm = $this->createDeleteForm($cSR);

        return $this->render('csr/show.html.twig', array(
            'cSR' => $cSR,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cSR entity.
     *
     */
    public function editAction(Request $request, CSR $cSR)
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('LocationBundle:Client')->findAll();
        $voitures = $em->getRepository('LocationBundle:Voiture')->findAll();
		$cin1=$cSR->getConducteur1()->getCin();
		$nom1=$cSR->getConducteur1()->getNom();
		$prenom1=$cSR->getConducteur1()->getPrenom();
		$numpermis1=$cSR->getConducteur1()->getNumPermis();
		$nationalite1=$cSR->getConducteur1()->getNationalite();
		$cin=$cSR->getConducteur2()->getCin();
		$nom=$cSR->getConducteur2()->getNom();
		$prenom=$cSR->getConducteur2()->getPrenom();
		$numpermis=$cSR->getConducteur2()->getNumPermis();
		$nationalite=$cSR->getConducteur2()->getNationalite();
        $matricule=$cSR->getRefVoiture()->getMatricule();
        $marque=$cSR->getRefVoiture()->getMarque();
        $modele=$cSR->getRefVoiture()->getModele();
        $couleur=$cSR->getRefVoiture()->getCouleur();
        $prix=$cSR->getRefVoiture()->getPrix();
        $deleteForm = $this->createDeleteForm($cSR);
        $editForm = $this->createForm('LV\LocationBundle\Form\CSRType', $cSR);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('csr_index', array('id' => $cSR->getId()));
        }

        return $this->render('csr/edit.html.twig', array(
            'cSR' => $cSR,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'voitures' => $voitures,
            'matricule' => $matricule,
            'marque' => $marque,
            'couleur' => $couleur,
            'modele' => $modele,
            'prix' => $prix,
            'cin' => $cin,
            'nom' => $nom,
            'prenom' => $prenom,
            'numpermis' => $numpermis,
            'nationalite' => $nationalite,
            'cin1' => $cin1,
            'nom1' => $nom1,
            'prenom1' => $prenom1,
            'numpermis1' => $numpermis1,
            'nationalite1' => $nationalite1,
            'clients' => $clients,
            'voitures' => $voitures,
        ));
    }

    /**
     * Deletes a cSR entity.
     *
     */
    public function deleteAction(Request $request, CSR $cSR)
    {
        $em= $this->getDoctrine()->getManager();
        $objectsRepository = $em->getRepository('LocationBundle:CSR');
        $r = $objectsRepository->findOneById($cSR->getId());
        $form = $this->createDeleteForm($cSR);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dateDebut=$cSR->getDateDebut();
            $dateFin=$cSR->getDateFin();
            $id_matricule=$cSR->getRefVoiture()->getId();
            $rep2 = $em->getRepository(Disponibilite::class);
            $res = $rep2->createQueryBuilder('d')
             ->delete()
             ->where('d.dateDebut = :date1 and d.dateFin = :date2 and d.refVoiture = :id_matricule')
             ->setParameter('date1', $dateDebut)
             ->setParameter('date2', $dateFin)
             ->setParameter('id_matricule', $id_matricule)
             ->getQuery()
            ->execute();
            $em->remove($cSR);
            $em->flush();
        }

        return $this->redirectToRoute('csr_index');
    }

    /**
     * Creates a form to delete a cSR entity.
     *
     * @param CSR $cSR The cSR entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CSR $cSR)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('csr_delete', array('id' => $cSR->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
