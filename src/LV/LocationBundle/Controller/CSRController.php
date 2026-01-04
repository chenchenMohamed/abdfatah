<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\CSR;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use LV\LocationBundle\Entity\Disponibilite;
use LV\LocationBundle\Entity\Paiement;
use LV\LocationBundle\Entity\Reservation;
use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Contrat;
use LV\LocationBundle\Entity\Client;
//use Doctrine\ORM\Tools\Pagination\Paginator;
//use LV\LocationBundle\Entity\Client;
//use LV\LocationBundle\Form\ClientForm;

/**
 * Csr controller.
 *
 */
class CSRController extends Controller
{

      public function addClientAction(Request $request) {
            
            $client = new Client();
            $client->setNom($request->nom);
            $clint->setPrenom($request->prenom);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            return response()->json($categorie);
        
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
        $factures = $em->getRepository('LocationBundle:Facture')->findAll();
        $em = $this->getDoctrine()->getManager();
        
        if($cSRs == null){
             $query = $em->createQuery("SELECT c FROM LV\LocationBundle\Entity\Contrat c ORDER BY c.numContrat DESC");
            $results = $query->getResult();
        }
        else if($contrats == null){
             $query = $em->createQuery("SELECT csr FROM LV\LocationBundle\Entity\CSR csr ORDER BY csr.id DESC");
              //->setFirstResult(0)
              //->setMaxResults(50);;
            $results = $query->getResult();
            //$results = new Paginator($query, $fetchJoinCollection = true);
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
            'factures' => $factures,
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
        $client->setDisponibilite(true);
        $client2->setDisponibilite(true);
        $disponibilite = new Disponibilite();
        $d1 = str_replace ( 'T', ' ', $time1);
        $f1 = str_replace ( 'T', ' ', $time2);
        $cSR->setDateDebut(new \DateTime($d1));
        $cSR->setDateFin(new \DateTime($f1));
        $em1 = $this->getDoctrine()->getManager();
        $v = $em1->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);
        $cSR->setRefVoiture($v);
        $voitures = $em1->getRepository('LocationBundle:Voiture')->findAll();
        $matricule=$v->getMatricule();
        $couleur=$v->getCouleur();
        $marque=$v->getMarque();
        $modele=$v->getModele();
        $prix=$v->getprix();
        $cSR->setKmDepart($v->getKm());
        $cSR->setDegats(false);
        $cSR->setNbreJour($result);
        $cSR->setTarif($prix);
        $total = (Int)$result * $prix;
        $cSR->setRecette($total);
        $TVA = (19*$total)/100; 
        $cSR->setTVA($TVA);
        $cSR->setTotalHTVA($total-$TVA);
        $cSR->setSousTotal($total+$TVA);
        $timbre = 1.000; 
        $cSR->setTimbre($timbre);
        $cSR->setTotal($total+$TVA+$timbre);

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
       
        //$c1 = $request->get('lv_locationbundle_csr')['conducteur1'];
        //$c2 = $request->get('lv_locationbundle_csr')['conducteur2'];

     //   $matricule = dump($request->request->get('lv_locationbundle_csr')['refVoiture']);
        //$veh = $em1->getRepository(Voiture::class)->findOneById($matricule);
        $disponibilite->setDateDebut(new \DateTime($dd));
        $disponibilite->setDateFin(new \DateTime($df));        
        $disponibilite->setRefVoiture($v);
        $disponibilite->setEtat('Louée');



        $form2 = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
        $form2->handleRequest($request);

        $form3 = $this->createForm('LV\LocationBundle\Form\ClientType', $client2);
        $form3->handleRequest($request);

        $nom1='';$prenom1='';$dateNaissance1='';$cin1='';$numPermis1='';$delivre1='';$adresse1='';$nationalite1='';
        $nom2='';$prenom2='';$dateNaissance2='';$cin2='';$numPermis2='';$delivre2='';$adresse2='';$nationalite2='';
        $selected1='';$selected2='';

        if ($form2->isSubmitted() && $form2->isValid() && isset($_POST['test1']) ) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            $_GET['c1'] = $client->getId();
            
         //$cSR->setConducteur1($client);
         // $nom1=$client->getNom();$prenom1=$client->getPrenom();$dateNaissance1=$client->getDateNaissance();$cin1=$client->getCin();$numPermis1=$client->getNumPermis();$delivre1=$client->getDelivre();$adresse1=$client->getAdresse();$nationalite1=$client->getNationalite();
         
        }

        elseif ($form3->isSubmitted() && $form3->isValid() && isset($_POST['test2'])) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($client2);
            $em->flush();
            $_GET['c2'] = $client2->getId();

        }

         //$cSR->setConducteur2($client2);
         // $nom2=$client->getNom();$prenom2=$client->getPrenom();$dateNaissance2=$client->getDateNaissance();$cin2=$client->getCin();$numPermis2=$client->getNumPermis();$delivre2=$client->getDelivre();$adresse2=$client->getAdresse();$nationalite2=$client->getNationalite();
         
       
        if (isset($_GET['c1']) && $_GET['c1'] != 0) {
         $c1 = $em1->getRepository('LocationBundle:Client')->findOneById($_GET['c1']);
         $cSR->setConducteur1($c1);
         $nom1=$c1->getNom();$prenom1=$c1->getPrenom();$dateNaissance1=$c1->getDateNaissance();$cin1=$c1->getCin();$numPermis1=$c1->getNumPermis();$delivre1=$c1->getDelivre();$adresse1=$c1->getAdresse();$nationalite1=$c1->getNationalite();
        }
        // elseif($_GET['c1'] == 0){
        //  $c1 = $em1->getRepository(Client::class)->findOneBy(array(), array('id' => 'desc'));
        //  $cSR->setConducteur1($c1);
        //  $nom1=$c1->getNom();$prenom1=$c1->getPrenom();$dateNaissance1=$c1->getDateNaissance();$cin1=$c1->getCin();$numPermis1=$c1->getNumPermis();$delivre1=$c1->getDelivre();$adresse1=$c1->getAdresse();$nationalite1=$c1->getNationalite();
        // }

        if (isset($_GET['c2']) && $_GET['c2'] != 0) {
         $c2 = $em1->getRepository('LocationBundle:Client')->findOneById($_GET['c2']);
         $cSR->setConducteur2($c2);
         $nom2=$c2->getNom();$prenom2=$c2->getPrenom();$dateNaissance2=$c2->getDateNaissance();$cin2=$c2->getCin();$numPermis2=$c2->getNumPermis();$delivre2=$c2->getDelivre();$adresse2=$c2->getAdresse();$nationalite2=$c2->getNationalite();
        }
        // elseif($_GET['c2'] == 0){
        //  $c2 = $em1->getRepository(Client::class)->findOneBy(array(), array('id' => 'desc'));
        //  $cSR->setConducteur2($c2);
        //  $nom2=$c2->getNom();$prenom2=$c2->getPrenom();$dateNaissance2=$c2->getDateNaissance();$cin2=$c2->getCin();$numPermis2=$c2->getNumPermis();$delivre2=$c2->getDelivre();$adresse2=$c2->getAdresse();$nationalite2=$c2->getNationalite();
        // }
        $clients = $em1->getRepository('LocationBundle:Client')->findAll();
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
            $em->persist($cSR);
            $disponibilite->setRefClient($cSR->getConducteur1());
            $em->persist($disponibilite);
            $em->flush();

            return $this->redirectToRoute('csr_index');
        }

        return $this->render('csr/new1.html.twig', array(
            'cSR' => $cSR,
            'form' => $form->createView(),
            'form_client' => $form2->createView(),
            'form_client2' => $form3->createView(),
      //      'form_client2' => $form3->createView(),
            'clients' => $clients,
            'voitures' => $voitures,
            'matricule' => $matricule,
            'couleur' => $couleur,
            'marque' => $marque,
            'modele' => $modele,
            'prix' => $prix,
            'time1'=> $time1,
            'time2' => $time2,
            'nom1'=>$nom1,'prenom1'=>$prenom1,'dateNaissance1'=>$dateNaissance1,'cin1'=>$cin1,'numPermis1'=>$numPermis1,'delivre1'=>$delivre1,'adresse1'=>$adresse1,'nationalite1'=>$nationalite1,
            'nom2'=>$nom2,'prenom2'=>$prenom2,'dateNaissance2'=>$dateNaissance2,'cin2'=>$cin2,'numPermis2'=>$numPermis2,'delivre2'=>$delivre2,'adresse2'=>$adresse2,'nationalite2'=>$nationalite2,
            'client'=>$client,
            'client2'=> $client2,
            'result'=> $result,
            'voiture' => $voiture,
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
            $em->persist($cSR);
            $refClient =  $cSR->getConducteur1();
            $disponibilite->setrefClient($refClient);
            $em->persist($disponibilite);
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
        $dateNaissance1=$cSR->getConducteur1()->getDateNaissance();
        
        if($dateNaissance1 != null){
        $dateNaissance1 = $dateNaissance1->format('d/m/Y');}

        $numpermis1=$cSR->getConducteur1()->getNumPermis();
        $delivre1=$cSR->getConducteur1()->getDelivre();
        
        if($delivre1 != null){
        $delivre1 = $delivre1->format('d/m/Y');}

        $nationalite1=$cSR->getConducteur1()->getNationalite();
        $adresse1=$cSR->getConducteur1()->getAdresse();
        if($cSR->getConducteur2() != null){
        $cin=$cSR->getConducteur2()->getCin();
        $nom=$cSR->getConducteur2()->getNom();
        $prenom=$cSR->getConducteur2()->getPrenom();
        $dateNaissance=$cSR->getConducteur2()->getDateNaissance();
        $dateNaissance = $dateNaissance->format('d/m/Y');
        $numpermis=$cSR->getConducteur2()->getNumPermis();
        $delivre=$cSR->getConducteur2()->getDelivre();
        $delivre = $delivre->format('d/m/Y');
        $nationalite=$cSR->getConducteur2()->getNationalite();
        $adresse=$cSR->getConducteur2()->getAdresse();
        }
        else{
        $cin=null;
        $nom=null;
        $prenom=null;
        $dateNaissance=null;
        $numpermis=null;
        $delivre=null;
        $nationalite=null;
        $adresse=null;
        };
        $matricule=$cSR->getRefVoiture()->getMatricule();
        $marque=$cSR->getRefVoiture()->getMarque();
        $modele=$cSR->getRefVoiture()->getModele();
        $couleur=$cSR->getRefVoiture()->getCouleur();
        $prix=$cSR->getRefVoiture()->getPrix();
        $dateFin=$cSR->getDateFin();
        $dateDebut=$cSR->getDateDebut();
        $deleteForm = $this->createDeleteForm($cSR);
        $editForm = $this->createForm('LV\LocationBundle\Form\CSRType', $cSR);
        $editForm->handleRequest($request);
        $errors = '';

        $time1 = $cSR->getDateDebut();
        $time1 = $time1->format('Y-m-d H:i');
        $time1 = str_replace (' ', 'T', $time1);
        $time2 = $cSR->getDateFin();
        $time2 = $time2->format('Y-m-d H:i');
        $time2 = str_replace (' ', 'T', $time2);

        $dateDepart = $request->get('lv_locationbundle_csr')['dateDebut'];
        $dateArrivee = $request->get('lv_locationbundle_csr')['dateFin'];
        $newRecette = $request->get('lv_locationbundle_csr')['total'];
        

        $kmRetour = $request->get('lv_locationbundle_csr')['kmRetour'];
        $degats = $request->get('lv_locationbundle_csr')['degats'];
        $etatRetour = $request->get('lv_locationbundle_csr')['etatRetour'];
        

        $repository = $this->getDoctrine()->getRepository(Disponibilite::class);
        $query = $repository->createQueryBuilder('m')
        ->where('m.dateDebut >= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin >= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->orwhere('m.dateDebut <= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin >= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->orwhere('m.dateDebut <= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin <= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->orwhere('m.dateDebut >= :date1 and m.dateDebut <= :date2 and m.dateFin >= :date1 and m.dateFin <= :date2 and IDENTITY(m.refVoiture) = :vehicule and IDENTITY(m.refClient) <> :client')
        ->setParameter('date1', $dateDepart)
        ->setParameter('date2', $dateArrivee)
        ->setParameter('vehicule', $cSR->getRefVoiture())
        ->setParameter('client', $cSR->getConducteur1())
        ->orderBy('m.dateFin', 'DESC')
        ->getQuery();
        $disponibilites = $query->getResult();
        
        
        $repository2 = $this->getDoctrine()->getRepository(Paiement::class);
        $query2 = $repository2->createQueryBuilder('m')
        ->where('IDENTITY(m.refCsr) = :id')
        ->setParameter('id', $cSR)
        ->getQuery();
        $paiements = $query2->getResult();
        //var_dump($paiements);
        //$duree = $request->get('lv_locationBundle_csr')['nbreJour'];
        //$duree = (int)$duree;
        $montantTotal = $request->get('lv_locationBundle_csr')['recette'];
        /*if($paiements != null){$nbreJour = ceil($paiements[0]->getMontantPaye()/$cSR->getTarif());
        }
        else{$nbreJour = 0;}*/
        /*if($paiements != null){$montantPaye = $paiements[0]->getMontantPaye();
        }
        else{$montantPaye = 0;}*/
        //var_dump($nbreJour);

        //var_dump($disponibilites);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($disponibilites == null and $paiements != null)
            {
            $em = $this->getDoctrine()->getManager();
            //$this->getDoctrine()->getManager()->flush();
            //$duree = (int)($cSR->getNbreJour());
            //$newRecette = $cSR->getRectte();
            $montantPaye = $paiements[0]->getMontantPaye();
           
            $query = $em->getRepository(Disponibilite::class)->createQueryBuilder('')
            ->update(disponibilite::class, 'v')
            ->set('v.dateFin', ':dateArrivee')
            ->set('v.dateDebut', ':dateDepart')
            ->where('v.refVoiture = :matricule')
            ->andwhere('v.dateDebut = :dateDebut')
            ->andwhere('v.dateFin= :dateFin')
            ->setParameter('dateArrivee', $dateArrivee)
            ->setParameter('dateDepart', $dateDepart)
            ->setParameter('matricule', $cSR->getRefVoiture())
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery();
            $result = $query->execute();

            $newRecette = (float) $newRecette;
            if($newRecette>$montantPaye){
             $query3 = $em->getRepository(Paiement::class)->createQueryBuilder('')
            ->update(paiement::class, 'v')
            ->set('v.montantRestant', ':montantRestant')
            ->set('v.montantPaye', ':montantPaye')
            ->where('IDENTITY(v.refCsr) = :id')
            ->setParameter('montantRestant', $newRecette-$montantPaye)
            ->setParameter('montantPaye', $paiements[0]->getMontantPaye())
            ->setParameter('id', $cSR)
            ->getQuery();
            $result3 = $query3->execute();
            }
            else{

             $query3 = $em->getRepository(Paiement::class)->createQueryBuilder('')
            ->update(paiement::class, 'v')
            ->set('v.montantPaye', ':montantPaye')
            ->set('v.montantRestant', ':montantRestant')
            ->where('IDENTITY(v.refCsr) = :id')
            ->setParameter('montantPaye',$newRecette)
            ->setParameter('montantRestant', 0)
            ->setParameter('id', $cSR)
            ->getQuery();
            $result3 = $query3->execute();
            }
            

            $query11 = $em->getRepository(Client::class)->createQueryBuilder('')
            ->update(Client::class, 'c')
            ->set('c.degat', ':degat')
            ->where('c.id = :id')
            ->set('c.cause', ':cause')
            ->setParameter('degat', $degats)
            ->setParameter('cause', $etatRetour)
            ->setParameter('id', $cSR->getConducteur1()->getId())
            ->getQuery();
            $result11 = $query11->execute();
            
            if($kmRetour != null){
            $query12 = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.km', ':km')
            ->where('v.matricule = :matricule')
            ->setParameter('km', $kmRetour)
            ->setParameter('matricule', $cSR->getRefVoiture()->getMatricule())
            ->getQuery();
            $result12 = $query12->execute();
            }
            

             $this->getDoctrine()->getManager()->flush();
            }

            elseif ($disponibilites == null and $paiements == null)
            {
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Disponibilite::class)->createQueryBuilder('')
            ->update(disponibilite::class, 'v')
            ->set('v.dateFin', ':dateArrivee')
            ->set('v.dateDebut', ':dateDepart')
            ->where('v.refVoiture = :matricule')
            ->andwhere('v.dateDebut = :dateDebut')
            ->andwhere('v.dateFin= :dateFin')
            ->setParameter('dateArrivee', $dateArrivee)
            ->setParameter('dateDepart', $dateDepart)
            ->setParameter('matricule', $cSR->getRefVoiture())
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery();
            $result = $query->execute();
            
            $query11 = $em->getRepository(Client::class)->createQueryBuilder('')
            ->update(Client::class, 'c')
            ->set('c.degat', ':degat')
            ->where('c.id = :id')
            ->set('c.cause', ':cause')
            ->setParameter('degat', $degats)
            ->setParameter('cause', $etatRetour)
            ->setParameter('id', $cSR->getConducteur1()->getId())
            ->getQuery();
            $result11 = $query11->execute();

            if($kmRetour != null){
            $query12 = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.km', ':km')
            ->where('v.matricule = :matricule')
            ->setParameter('km', $kmRetour)
            ->setParameter('matricule', $cSR->getRefVoiture()->getMatricule())
            ->getQuery();
            $result12 = $query12->execute();
            }
            

            $this->getDoctrine()->getManager()->flush();
            }
            
            
            else
            {
            $errors = 'Dates invalides : cette voiture est '.$disponibilites[0]->getEtat().' par le client '.$disponibilites[0]->getRefClient()->getPrenom().' '.$disponibilites[0]->getRefClient()->getNom();

            return $this->render('csr/edit.html.twig', array(
            'errors' => $errors,
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
            'dateNaissance' => $dateNaissance,
            'numpermis' => $numpermis,
            'delivre' => $delivre,
            'nationalite' => $nationalite,
            'adresse' => $adresse,
            'cin1' => $cin1,
            'nom1' => $nom1,
            'prenom1' => $prenom1,
            'dateNaissance1' => $dateNaissance1,
            'numpermis1' => $numpermis1,
            'delivre1' => $delivre1,
            'nationalite1' => $nationalite1,
            'adresse1' => $adresse1,
            'clients' => $clients,
            'time1' => $time1,
            'time2' => $time2,
            ));
            }

            return $this->redirectToRoute('csr_index', array('id' => $cSR->getId()));
        }

        return $this->render('csr/edit.html.twig', array(
            'errors' => $errors,
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
            'dateNaissance' => $dateNaissance,
            'numpermis' => $numpermis,
            'delivre' => $delivre,
            'nationalite' => $nationalite,
            'adresse' => $adresse,
            'cin1' => $cin1,
            'nom1' => $nom1,
            'prenom1' => $prenom1,
            'dateNaissance1' => $dateNaissance1,
            'numpermis1' => $numpermis1,
            'delivre1' => $delivre1,
            'nationalite1' => $nationalite1,
            'adresse1' => $adresse1,
            'clients' => $clients,
            'voitures' => $voitures,
            'time1' => $time1,
            'time2' => $time2,
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
            if($cSR->getRefReservation() != null){
            $sup = $em->getRepository(Reservation::class);
            $sup2 = $sup->createQueryBuilder('s')
             ->delete()
             ->where('s.id = :id')
             ->setParameter('id', $cSR->getRefReservation()->getId())
             ->getQuery()
            ->execute();
            }
            
            $em->remove($cSR);
            $em->flush();
        

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
