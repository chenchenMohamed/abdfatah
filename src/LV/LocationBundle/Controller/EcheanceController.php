<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Echeance;
use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\PaiementEcheance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Echeance controller.
 *
 */
class EcheanceController extends Controller
{
    /**
     * Lists all echeance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $echeances = $em->getRepository('LocationBundle:Echeance')->findAll();

        return $this->render('echeance/index.html.twig', array(
            'echeances' => $echeances,
        ));
    }

     public function detailAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        //$echeances = $em->getRepository('LocationBundle:Echeance')->findAll();

        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Echeance');
        $echeance = $objectsRepository->findOneById($id);
        $aa = $echeance->getDatePremierPay();
        $bb = $echeance->getDateDernierPay();
        $start = $aa->format('Y-m-d');
        $end = $bb->format('Y-m-d');
        sscanf($start, "%4s-%2s-%2s", $annee, $mois, $jour);
        $a1 = $annee;
        $m1 = $mois;
        sscanf($end, "%4s-%2s-%2s", $annee, $mois, $jour);
        $a2 = $annee;
        $m2 = $mois;

        $dif_en_mois = ($m2-$m1)+12*($a2-$a1)+1;

        $paiementEcheances = $em->getRepository('LocationBundle:PaiementEcheance')->findAll();

        
       
        $repository = $this->getDoctrine()->getRepository(PaiementEcheance::class);
        $query = $repository->createQueryBuilder('d')
        ->where('d.refEcheance = :id')
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

        return $this->render('echeance/detail.html.twig', array(
            'echeance' => $echeance,
            'dif_en_mois' => $dif_en_mois,
            'paiementEcheances' => $paiementEcheances,
            'dt' => $dt,
        ));
    }

    /**
     * Creates a new echeance entity.
     *
     */
    public function newAction(Request $request)
    {
        $echeance = new Echeance();
        
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime();
        $echeance->setDatePremierPay($now);
        $echeance->setMontantPaye(0);
        $echeance->setEtat('Non payé');
        $form = $this->createForm('LV\LocationBundle\Form\EcheanceType', $echeance);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($echeance);
            $em->flush();

            return $this->redirectToRoute('echeance_index', array('id' => $echeance->getId()));
        }

        return $this->render('echeance/new.html.twig', array(
            'echeance' => $echeance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a echeance entity.
     *
     */
    public function showAction(Echeance $echeance)
    {
        $deleteForm = $this->createDeleteForm($echeance);

        return $this->render('echeance/show.html.twig', array(
            'echeance' => $echeance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing echeance entity.
     *
     */
    public function editAction(Request $request, Echeance $echeance)
    {
        $voiture = $echeance->getRefVoiture()->getMatricule();
        $datePremierPay = $echeance->getDatePremierPay();
        $dateDernierPay = $echeance->getDateDernierPay();
        $deleteForm = $this->createDeleteForm($echeance);
        $editForm = $this->createForm('LV\LocationBundle\Form\EcheanceType', $echeance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('echeance_index', array('id' => $echeance->getId()));
        }

        return $this->render('echeance/edit.html.twig', array(
            'echeance' => $echeance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'voiture' => $voiture,
            'datePremierPay' => $datePremierPay,
            'dateDernierPay' => $dateDernierPay,
        ));
    }

    /**
     * Deletes a echeance entity.
     *
     */
    public function deleteAction(Request $request, Echeance $echeance)
    {
        $form = $this->createDeleteForm($echeance);
        $form->handleRequest($request);

        
            $em = $this->getDoctrine()->getManager();
            $em->remove($echeance);
            $em->flush();
        

        return $this->redirectToRoute('echeance_index');
    }

    /**
     * Creates a form to delete a echeance entity.
     *
     * @param Echeance $echeance The echeance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Echeance $echeance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('echeance_delete', array('id' => $echeance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
