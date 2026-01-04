<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\PaiementEcheance;
use LV\LocationBundle\Entity\Echeance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paiementecheance controller.
 *
 */
class PaiementEcheanceController extends Controller
{
    /**
     * Lists all paiementEcheance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paiementEcheances = $em->getRepository('LocationBundle:PaiementEcheance')->findAll();

        return $this->render('paiementecheance/index.html.twig', array(
            'paiementEcheances' => $paiementEcheances,
        ));
    }

    /**
     * Creates a new paiementEcheance entity.
     *
     */
    public function newAction(Request $request, $id, $date)
    {
        $paiementEcheance = new Paiementecheance();

        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Echeance');
        $e = $objectsRepository->findOneById($id);
        $paiementEcheance->setMontant($e->getMontantMensuel());
        $paiementEcheance->setDate(new \DateTime($date));
        $paiementEcheance->setRefEcheance($e);
        $form = $this->createForm('LV\LocationBundle\Form\PaiementEcheanceType', $paiementEcheance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(($e->getMontantPaye()+$e->getMontantMensuel())>=$e->getMontantTotal() or ($e->getNbrePayRestant()-1 == 0)){

            $query = $em->getRepository(Echeance::class)->createQueryBuilder('')
            ->update(Echeance::class, 'd')
            ->set('d.montantPaye', ':mp')
            ->set('d.montantRestant', ':mr')
            ->set('d.nbrePayRestant', ':npr')
            ->set('d.etat', ':etat')
            ->where('d.id = :id')
            ->setParameter('mp', $e->getMontantTotal())
            ->setParameter('mr', 0)
            ->setParameter('npr', 0)
            ->setParameter('etat', 'Payée')
            ->setParameter('id', $id)
            ->getQuery();
            $result = $query->execute();
                $em->persist($paiementEcheance);
                $em->flush();

            }else{
            $query = $em->getRepository(Echeance::class)->createQueryBuilder('')
            ->update(Echeance::class, 'd')
            ->set('d.montantPaye', ':mp')
            ->set('d.montantRestant', ':mr')
            ->set('d.nbrePayRestant', ':npr')
            ->where('d.id = :id')
            ->setParameter('mp', $e->getMontantPaye()+$e->getMontantMensuel())
            ->setParameter('mr', $e->getMontantRestant()-$e->getMontantMensuel())
            ->setParameter('npr', $e->getNbrePayRestant()-1)
            ->setParameter('id', $id)
            ->getQuery();
            $result = $query->execute();
                 $em->persist($paiementEcheance);
                 $em->flush();
            }
           

            return $this->redirectToRoute('echeance_detail', array('id' => $id));
        }

        return $this->render('paiementecheance/new.html.twig', array(
            'paiementEcheance' => $paiementEcheance,
            'form' => $form->createView(),
            'echeance' => $e,
        ));
    }

    public function annulerAction(Request $request, $id, $date)
    {
    
        $objectsRepository2 = $this->getDoctrine()->getRepository('LocationBundle:Echeance');
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:PaiementEcheance');
        $p= $objectsRepository->findOneByRefEcheance($id);
        $s = $objectsRepository2->findOneById($id);
       
            $em = $this->getDoctrine()->getManager();
            //if(($s->getMontantPaye()+$s->getMontantMensuel())>=$s->getMontantTotal())
            if($s->getMontantPaye()-$s->getMontantMensuel()>1){
            $query = $em->getRepository(Echeance::class)->createQueryBuilder('')
            ->update(Echeance::class, 'd')
            ->set('d.montantPaye', ':mp')
            ->set('d.montantRestant', ':mr')
            ->set('d.nbrePayRestant', ':npr')
            ->set('d.etat', ':etat')
            ->where('d.id = :id')
            ->setParameter('mp', $s->getMontantPaye()-$s->getMontantMensuel())
            ->setParameter('mr', $s->getMontantRestant()+$s->getMontantMensuel())
            ->setParameter('npr', $s->getNbrePayRestant()+1)
            ->setParameter('etat', 'Non payé')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();}
            else{
            $query = $em->getRepository(Echeance::class)->createQueryBuilder('')
            ->update(Echeance::class, 'd')
            ->set('d.montantPaye', ':mp')
            ->set('d.montantRestant', ':mr')
            ->set('d.nbrePayRestant', ':npr')
            ->set('d.etat', ':etat')
            ->where('d.id = :id')
            ->setParameter('mp', 0)
            ->setParameter('mr', $s->getMontantTotal())
            ->setParameter('npr', $s->getNbrePayRestant()+1)
            ->setParameter('etat', 'Non payé')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
            }
            //$em->persist($paiementSoustraitance);
            //$em->flush();


            $rep2 = $em->getRepository(PaiementEcheance::class);
            $res = $rep2->createQueryBuilder('d')
             ->delete()
             ->where('d.date = :date and d.refEcheance = :refEcheance')
             ->setParameter('date', new \DateTime($date))
             ->setParameter('refEcheance', $s)
             ->getQuery()
            ->execute();
            //$em->remove($reservation);
            $em->flush();

            
            return $this->redirectToRoute('echeance_detail', array('id' => $id));

    }

    /**
     * Finds and displays a paiementEcheance entity.
     *
     */
    public function showAction(PaiementEcheance $paiementEcheance)
    {
        $deleteForm = $this->createDeleteForm($paiementEcheance);

        return $this->render('paiementecheance/show.html.twig', array(
            'paiementEcheance' => $paiementEcheance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paiementEcheance entity.
     *
     */
    public function editAction(Request $request, PaiementEcheance $paiementEcheance)
    {
        $deleteForm = $this->createDeleteForm($paiementEcheance);
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementEcheanceType', $paiementEcheance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiementecheance_edit', array('id' => $paiementEcheance->getId()));
        }

        return $this->render('paiementecheance/edit.html.twig', array(
            'paiementEcheance' => $paiementEcheance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paiementEcheance entity.
     *
     */
    public function deleteAction(Request $request, PaiementEcheance $paiementEcheance)
    {
        $form = $this->createDeleteForm($paiementEcheance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paiementEcheance);
            $em->flush();
        }

        return $this->redirectToRoute('paiementecheance_index');
    }

    /**
     * Creates a form to delete a paiementEcheance entity.
     *
     * @param PaiementEcheance $paiementEcheance The paiementEcheance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PaiementEcheance $paiementEcheance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paiementecheance_delete', array('id' => $paiementEcheance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
