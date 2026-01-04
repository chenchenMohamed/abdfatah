<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Paiement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\LocationBundle\Entity\Contrat;
use LV\LocationBundle\Entity\CSR;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Paiement controller.
 *
 */
class PaiementController extends Controller
{ 
    /** 
     * Lists all paiement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paiements = $em->getRepository('LocationBundle:Paiement')->findAll();
        $factures = $em->getRepository('LocationBundle:Facture')->findAll();

        return $this->render('paiement/index.html.twig', array(
            'paiements' => $paiements,
            'factures' => $factures,
        ));
    }

    /**
     * Creates a new paiement entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Contrat');
        $c = $objectsRepository->findOneById($id);
        $recette = $c->getRecette();
        
        $paiement = new Paiement();
        $paiement->setRefContrat($c);
        $refcontrat=$c->getNumContrat();
        $form = $this->createForm('LV\LocationBundle\Form\PaiementType', $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paiement);
            $em->flush();

            return $this->redirectToRoute('contrat_index', array('id' => $paiement->getId()));
        }

        return $this->render('paiement/new.html.twig', array(
            'paiement' => $paiement,
            'form' => $form->createView(),
            'recette' => $recette,
            'refcontrat' => $refcontrat,
        ));
    }

    /**
     * Creates a new paiement entity.
     *
     */
    public function new2Action(Request $request, $id)
    {
        $paiement = new Paiement();
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:CSR');
        $c = $objectsRepository->findOneById($id);
        $recette = $c->getTotal();
        $paiement->setRefCsr($c);
        $num = $c->getnumContrat();
        $form = $this->createForm('LV\LocationBundle\Form\PaiementType', $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paiement);
            $em->flush();

            return $this->redirectToRoute('csr_index', array('id' => $paiement->getId()));
        }

        return $this->render('paiement/new2.html.twig', array(
            'paiement' => $paiement,
            'form' => $form->createView(),
            'recette' => $recette,
            'num' => $num,
        ));
    }

    /**
     * Finds and displays a paiement entity.
     *
     */
    public function showAction(Paiement $paiement)
    {
        $deleteForm = $this->createDeleteForm($paiement);

        return $this->render('paiement/show.html.twig', array(
            'paiement' => $paiement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paiement entity.
     *
     */
    public function editAction(Request $request, Paiement $paiement)
    {
        $deleteForm = $this->createDeleteForm($paiement);
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementType', $paiement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_index', array('id' => $paiement->getId()));
        }

        return $this->render('paiement/edit.html.twig', array(
            'paiement' => $paiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paiement entity.
     *
     */
public function edit1Action(Request $request,Contrat $contrat)
    {
     $p =$this->getDoctrine()->getRepository('LocationBundle:Contrat')->findOneById($contrat->getId());
 //   var_dump($p->getId());
     $paiement =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneByRefContrat($p->getId());
    // var_dump($paiement);
        $deleteForm = $this->createDeleteForm($paiement); 
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementType', $paiement);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $paye =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneById($paiement->getId());
            if($paye->getMontantPaye() == $contrat->getTotal()){
             $em = $this->getDoctrine()->getManager();
             $repository2 = $em->getRepository(Paiement::class);
             $query2 = $repository2->createQueryBuilder('')
             ->update(Paiement::class,'p')
             ->where('p.id = :id')
             ->setParameter('id', $paiement->getId())
             ->getQuery()
             ->getResult();
            }else{ 
            }
            return $this->redirectToRoute('csr_index', array('id' => $paiement->getId()));
        }
        return $this->render('paiement/edit.html.twig', array(
            'paiement' => $paiement,
            'contrat' => $p,
            'recette' => $p->getRecette(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'refcontrat' => $contrat->getNumContrat(),
            
        ));
    }
	
    /**
     * Displays a form to edit2 an existing paiement entity.
     *
     */
public function edit2Action(Request $request,CSR $contrat)
    {
     $p =$this->getDoctrine()->getRepository('LocationBundle:CSR')->findOneById($contrat->getId());
      $num = $contrat->getnumContrat();

     $paiement =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneByRefCsr($p->getId());
        $deleteForm = $this->createDeleteForm($paiement); 
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementType', $paiement);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $paye =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneById($paiement->getId());
            
            return $this->redirectToRoute('csr_index', array('id' => $paiement->getId()));
        }
        return $this->render('paiement/edit2.html.twig', array(
            'paiement' => $paiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'contrat' => $p,
            'recette' => $p->getTotal(),
            'num' => $num,
        ));
    }
  /**
     * Displays a form to edit3 an existing paiement entity.
     *
     */
public function edit3Action(Request $request,CSR $contrat)
    {
     $p =$this->getDoctrine()->getRepository('LocationBundle:CSR')->findOneById($contrat->getId());
    //var_dump($p->getId());

     $paiements =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneByRefContrat($p->getId());
     //var_dump($paiement); 
     $paiement->setRefCsr($p);
     //$paiement->setEtat($paiement->getEtat());
$refcsr=$contrat->getNumContrat();
     $paiement->setMontantPaye($paiements->getMontantPaye());
     $paiement->setMontantRestant($paiements->getMontantRestant());
     $paiement->setDateProchPayement($paiements->getDateProchPayement());
       
	 $deleteForm = $this->createDeleteForm($paiement); 
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementType', $paiement);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $paye =$this->getDoctrine()->getRepository('LocationBundle:Paiement')->findOneById($paiement->getId());
            if($paye->getMontantPaye() == $contrat->getRecette()){
             $em = $this->getDoctrine()->getManager();
             $repository2 = $em->getRepository(Paiement::class);
             $query2 = $repository2->createQueryBuilder('')
             ->update(Paiement::class,'p')
             ->set('p.etat',':et')
             ->where('p.id = :id')
             ->setParameter('id', $paiement->getId())
             ->setParameter('et', 'Payé')
             ->getQuery()
             ->getResult();
            }else{
            }
            return $this->redirectToRoute('paiement_index');
        }


        return $this->render('paiement/edit2.html.twig', array(
            'paiement' => $paiement,
            'contrat' => $p,
            'recette' => $p->getrecette(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'refcsr' => $refcsr,
        ));
    }

    /**
     * Deletes a paiement entity.
     *
     */
    public function deleteAction(Request $request, Paiement $paiement)
    {
        $form = $this->createDeleteForm($paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paiement);
            $em->flush();
        }

        return $this->redirectToRoute('paiement_index');
    }

    /**
     * Creates a form to delete a paiement entity.
     *
     * @param Paiement $paiement The paiement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paiement $paiement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paiement_delete', array('id' => $paiement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
