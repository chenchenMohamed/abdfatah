<?php

namespace LV\LocationBundle\Controller;
//require_once 'dompdf/autoload.inc.php';
use LV\LocationBundle\Entity\Contrat;
use LV\LocationBundle\Entity\CSR;
use LV\LocationBundle\Entity\Facture;
use LV\LocationBundle\Entity\Agence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Options;
use Dompdf\Dompdf;
//use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use LV\LocationBundle\Entity\Paiement;
//require_once 'dompdf/autoload.inc.php';

/**
 * Facture controller.
 *
 */
class FactureController extends Controller
{
    public function pdfAction($id) {

    $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Facture');
    $facture = $objectsRepository->findOneById($id);    

    $p =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneById($facture->getRefPayement()->getId());
    //var_dump($p->getId());
    if($nbreJour = $p->getRefCsr()->getRefReservation() == null){
        $nbreJour = $p->getRefCsr()->getNbreJour();
    }
    else{
         $nbreJour = $p->getRefCsr()->getRefReservation()->getNbreJour();
    }
  // var_dump($nbreJour);
        $temp = explode (' ', $nbreJour);
        $duree = $temp[0];
    // On récupère l'objet à afficher (rien d'inconnu jusque là)    
    // On crée une  instance pour définir les options de notre fichier pdf
    $options = new Options();
    // Pour simplifier l'affichage des images, on autorise dompdf à utiliser 
    // des  url pour les nom de  fichier
    $options->set('isRemoteEnabled', TRUE);
    // On crée une instance de dompdf avec  les options définies
    $dompdf = new Dompdf($options);
    // On demande à Symfony de générer  le code html  correspondant à 
    // notre template, et on stocke ce code dans une variable
    $html = $this->renderView(
      'facture/pdfTemplate.html.twig', 
      array('facture' => $facture,'duree' => $duree,)
    );
    // On envoie le code html  à notre instance de dompdf
    $dompdf->loadHtml($html);        
    // On demande à dompdf de générer le  pdf
    $dompdf->render();
    // On renvoie  le flux du fichier pdf dans une  Response pour l'utilisateur
    return new Response ($dompdf->stream("dompdf_out.pdf", array("Attachment" => false)));
}


    public function pdf2Action($id) {

    $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Facture');
    $facture = $objectsRepository->findOneById($id);    

    $p =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneById($facture->getRefPayement()->getId());
    //var_dump($p->getId());
   $nbreJour = $p->getRefCsr()->getNbreJour();
        $temp = explode (' ', $nbreJour);
        $duree = $temp[0];
    // On récupère l'objet à afficher (rien d'inconnu jusque là)    
    // On crée une  instance pour définir les options de notre fichier pdf
    $options = new Options();
    // Pour simplifier l'affichage des images, on autorise dompdf à utiliser 
    // des  url pour les nom de  fichier
    $options->set('isRemoteEnabled', TRUE);
    // On crée une instance de dompdf avec  les options définies
    $dompdf = new Dompdf($options);
    // On demande à Symfony de générer  le code html  correspondant à 
    // notre template, et on stocke ce code dans une variable
    $html = $this->renderView(
      'facture/pdfTemplate2.html.twig', 
      array('facture' => $facture,'duree' => $duree,)
    );
    // On envoie le code html  à notre instance de dompdf
    $dompdf->loadHtml($html);        
    // On demande à dompdf de générer le  pdf
    $dompdf->render();
    // On renvoie  le flux du fichier pdf dans une  Response pour l'utilisateur
    return new Response ($dompdf->stream("dompdf_out.pdf", array("Attachment" => false)));
}

    /**
     * Lists all facture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $factures = $em->getRepository('LocationBundle:Facture')->findAll();
        $csrs = $em->getRepository('LocationBundle:CSR')->findAll();
        $contrats = $em->getRepository('LocationBundle:Contrat')->findAll();

        return $this->render('facture/index.html.twig', array(
            'factures' => $factures,
            'csrs' =>$csrs,
            'contrats' => $contrats,
        ));
    }

    /**
     * Creates a new facture entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $agence = $em->getRepository('LocationBundle:Agence')->findOneById(1);

        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Paiement');
        $p = $objectsRepository->findOneById($id);

        $numContrat =  $p->getRefCsr()->getNumContrat();
        if($p->getRefCsr()->getRefReservation() == null){
            $matricule = $p->getRefCsr()->getrefVoiture()->getMatricule();
            $marque = $p->getRefCsr()->getrefVoiture()->getMarque();
            $modele = $p->getRefCsr()->getrefVoiture()->getModele();
            $nom = $p->getRefCsr()->getConducteur1()->getNom();
            $prenom = $p->getRefCsr()->getConducteur1()->getPrenom();
            $adresse = $p->getRefCsr()->getConducteur1()->getAdresse();
            $telephone = $p->getRefCsr()->getConducteur1()->getTelephone();
        }
        else{
            $matricule = $p->getRefCsr()->getRefReservation()->getrefVoiture()->getMatricule();
            $marque = $p->getRefCsr()->getRefReservation()->getrefVoiture()->getMarque();
            $modele = $p->getRefCsr()->getRefReservation()->getrefVoiture()->getModele();
            $nom = $p->getRefCsr()->getRefReservation()->getrefClient()->getNom();
            $prenom = $p->getRefCsr()->getRefReservation()->getrefClient()->getPrenom();
            $adresse = $p->getRefCsr()->getRefReservation()->getrefClient()->getAdresse();
            $telephone = $p->getRefCsr()->getRefReservation()->getrefClient()->getTelephone();
        }
       
        
        
        $datePayement = $p->getDatePayement();
        $datePayement = $datePayement->format('Y-m-d H:i:s');
        $recette = $p->getRefCsr()->getRecette();
        $montantPaye = $p->getMontantPaye();
        $montantRestant = $p->getMontantRestant();
        $typePayement = $p->getTypePayement();
        $dateContrat = $p->getRefCsr()->getDateContrat();
        $tarif = $p->getRefCsr()->getTarif();
        $nbreJour = $p->getRefCsr()->getNbreJour();
        $temp = explode (' ', $nbreJour);
        $duree = $temp[0];
        if ($typePayement == 'Chèque')
        {
           $numCheque = $p->getRefCheque()->getNumCheque(); 
        }
        else
        {
           $numCheque = null;   
        };
        
        
        $facture = new Facture();
        $facture->setRefPayement($p);
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime('NOW', $tz);
        $facture->setDateFacture($now);
            $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Facture::class)->findOneBy(array(), array('id' => 'desc'));
            //var_dump($rec2);
            $date = date('Y');
            //var_dump($date);
            if ($c == null)
            {
              $rnum='1'."/".$date;
              $facture->setNumFacture($rnum);
            }
            else
            {   
                $res = substr($c->getNumFacture(), (strlen($c->getNumFacture())-4), strlen($c->getNumFacture()));
                $res = (int) $res;
                $date1 = (int) $date;
              //  var_dump($res);
             //   var_dump($date1);
              //   var_dump($date1>$res);
                if($date1>$res)
                {
                $cid=$c->getId();
                $rnum=($cid-($cid-1))."/".$date;
               $facture->setNumFacture($rnum); 

                }else
                {
                $cid=$c->getId();
                $rnum=($cid+1)."/".$date;
               $facture->setNumFacture($rnum);  
                };
               
            };
           //var_dump($rnum);
        

        $form = $this->createForm('LV\LocationBundle\Form\FactureType', $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('csr_index');
        }

        return $this->render('facture/new.html.twig', array(
            'p' => $p,
            'facture' => $facture,
            'form' => $form->createView(),
            'numContrat' =>$numContrat,
            'matricule' => $matricule,
            'nom' => $nom,
            'rnum' => $rnum,
            'prenom' => $prenom,
            'datePayement' => $datePayement,
            'recette' => $recette,
            'montantPaye' => $montantPaye,
            'montantRestant' => $montantRestant,
            'typePayement' => $typePayement,
            'numCheque' => $numCheque,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'dateContrat' => $dateContrat,
            'tarif' => $tarif,
            'duree' => $duree,
            'marque' => $marque,
            'modele' => $modele,
            'agence' => $agence,
        ));
    }

      public function new2Action(Request $request, $id)
    {
        $object = $this->getDoctrine()->getRepository('LocationBundle:CSR');
        $obj = $object->findOneById($id);
     
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Paiement');
        $p = $objectsRepository->findOneByRefCsr($obj->getId());
       
        $numContrat =  $p->getRefCsr()->getNumContrat();
        $matricule = $p->getRefCsr()->getrefVoiture()->getMatricule();
        $nom = $p->getRefCsr()->getConducteur1()->getNom();
        $prenom = $p->getRefCsr()->getConducteur1()->getPrenom();
        $datePayement = $p->getDatePayement();
        $datePayement = $datePayement->format('Y-m-d H:i:s');
        $recette = $p->getRefCsr()->getRecette();
        $montantPaye = $p->getMontantPaye();
        $montantRestant = $p->getMontantRestant();
        $typePayement = $p->getTypePayement();
        if ($typePayement == 'Chèque')
        {
           $numCheque = $p->getRefCheque()->getNumCheque(); 
        }
        else
        {
           $numCheque = null;   
        };
        
        
        $facture = new Facture();
        $facture->setRefPayement($p);
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime('NOW', $tz);
        $facture->setDateFacture($now);
         $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Facture::class)->findOneBy(array(), array('id' => 'desc'));
            //var_dump($rec2);
            $date = date('Y');
            //var_dump($date);
            if ($c == null)
            {
              $rnum='1'."/".$date;
              $facture->setNumFacture($rnum);
            }
            else
            {   
                $res = substr($c->getNumFacture(), (strlen($c->getNumFacture())-4), strlen($c->getNumFacture()));
                $res = (int) $res;
                $date1 = (int) $date;
              //  var_dump($res);
             //   var_dump($date1);
              //   var_dump($date1>$res);
                if($date1>$res)
                {
                $cid=$c->getId();
                $rnum=($cid-($cid-1))."/".$date;
               $facture->setNumFacture($rnum); 

                }else
                {
                $cid=$c->getId();
                $rnum=($cid+1)."/".$date;
               $facture->setNumFacture($rnum);  
                };
               
            };

        $form = $this->createForm('LV\LocationBundle\Form\FactureType', $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('facture_show2', array('id' => $facture->getId()));
        }

        return $this->render('facture/new2.html.twig', array(
            'facture' => $facture,
            'form' => $form->createView(),
            'numContrat' =>$numContrat,
            'matricule' => $matricule,
            'nom' => $nom,
            'rnum' => $rnum,
            'prenom' => $prenom,
            'datePayement' => $datePayement,
            'recette' => $recette,
            'montantPaye' => $montantPaye,
            'montantRestant' => $montantRestant,
            'typePayement' => $typePayement,
            'numCheque' => $numCheque,
        ));
    }

    /**
     * Finds and displays a facture entity.
     *
     */
     public function showAction(Facture $facture)
    {
        $em = $this->getDoctrine()->getManager();

        $agence = $em->getRepository('LocationBundle:Agence')->findOneById(1);
        $deleteForm = $this->createDeleteForm($facture);
        $nbreJour = $facture->getRefPayement()->getRefCsr()->getNbreJour();
    
  // var_dump($nbreJour);
        $temp = explode (' ', $nbreJour);
        $duree = $temp[0];
//var_dump($facture);
    //    $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Paiement');
  //      $paiement = $objectsRepository->findOneByRefPaiement($facture->getId());
//var_dump($paiement->getId());

      //  $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Contrat');
        //$contrat = $objectsRepository->findOneById($id);
        return $this->render('facture/show.html.twig', array(
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
            'duree' => $duree,
            'agence' => $agence,
        ));
    }

     public function show2Action(Facture $facture)
    {
        $em = $this->getDoctrine()->getManager();

        $agence = $em->getRepository('LocationBundle:Agence')->findOneById(1);
        $deleteForm = $this->createDeleteForm($facture);
        $nbreJour = $facture->getRefPayement()->getRefCsr()->getNbreJour();
    
  // var_dump($nbreJour);
        $temp = explode (' ', $nbreJour);
        $duree = $temp[0];
//var_dump($facture);
    //    $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Paiement');
  //      $paiement = $objectsRepository->findOneByRefPaiement($facture->getId());
//var_dump($paiement->getId());

      //  $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Contrat');
        //$contrat = $objectsRepository->findOneById($id);
        return $this->render('facture/show2.html.twig', array(
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
            'duree' => $duree,
            'agence' => $agence,
        ));
    }

    /**
     * Creates a new facture entity.
     *
     */
    public function new1Action(Request $request, $id)
    {
        $object = $this->getDoctrine()->getRepository('LocationBundle:Contrat');
        $obj = $object->findOneById($id);
       // var_dump($obj->getRefContra());
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Paiement');
        $p = $objectsRepository->findOneByRefContrat($obj->getId());
       // var_dump($p->getId());
        $numContrat =  $p->getRefContrat()->getNumContrat();
        $matricule = $p->getRefContrat()->getRefReservation()->getrefVoiture()->getMatricule();
        $nom = $p->getRefContrat()->getRefReservation()->getrefClient()->getNom();
        $prenom = $p->getRefContrat()->getRefReservation()->getrefClient()->getPrenom();
        $datePayement = $p->getDatePayement();
        $datePayement = $datePayement->format('Y-m-d H:i:s');
        $recette = $p->getRefContrat()->getRecette();
        $montantPaye = $p->getMontantPaye();
        $montantRestant = $p->getMontantRestant();
        $typePayement = $p->getTypePayement();
        if ($typePayement == 'Chèque')
        {
           $numCheque = $p->getRefCheque()->getNumCheque(); 
        }
        else
        {
           $numCheque = null;   
        };
        
        
        $facture = new Facture();
        $facture->setRefPayement($p);
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime('NOW', $tz);
        $facture->setDateFacture($now);
        $em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Facture::class)->findOneBy(array(), array('id' => 'desc'));
            //var_dump($rec2);
            $date = date('Y');
            //var_dump($date);
            if ($c == null)
            {
              $rnum='1'."/".$date;
              $facture->setNumFacture($rnum);
            }
            else
            {   
                $res = substr($c->getNumFacture(), (strlen($c->getNumFacture())-4), strlen($c->getNumFacture()));
                $res = (int) $res;
                $date1 = (int) $date;
              //  var_dump($res);
             //   var_dump($date1);
              //   var_dump($date1>$res);
                if($date1>$res)
                {
                $cid=$c->getId();
                $rnum=($cid-($cid-1))."/".$date;
               $facture->setNumFacture($rnum); 

                }else
                {
                $cid=$c->getId();
                $rnum=($cid+1)."/".$date;
               $facture->setNumFacture($rnum);  
                };
               
            };
           //var_dump($rnum);
        

        $form = $this->createForm('LV\LocationBundle\Form\FactureType', $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        }

        return $this->render('facture/new.html.twig', array(
            'facture' => $facture,
            'form' => $form->createView(),
            'numContrat' =>$numContrat,
            'matricule' => $matricule,
            'nom' => $nom,
            'rnum' => $rnum,
            'prenom' => $prenom,
            'datePayement' => $datePayement,
            'recette' => $recette,
            'montantPaye' => $montantPaye,
            'montantRestant' => $montantRestant,
            'typePayement' => $typePayement,
            'numCheque' => $numCheque,
        ));
    }
    /**
     * Displays a form to edit an existing facture entity.
     *
     */
    public function editAction(Request $request, Facture $facture)
    {
        $deleteForm = $this->createDeleteForm($facture);
        $editForm = $this->createForm('LV\LocationBundle\Form\FactureType', $facture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_edit', array('id' => $facture->getId()));
        }

        return $this->render('facture/edit.html.twig', array(
            'facture' => $facture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a facture entity.
     *
     */
    public function deleteAction(Request $request, Facture $facture)
    {
        $form = $this->createDeleteForm($facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush();
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Creates a form to delete a facture entity.
     *
     * @param Facture $facture The facture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Facture $facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $facture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
