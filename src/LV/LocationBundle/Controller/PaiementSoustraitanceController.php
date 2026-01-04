<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\PaiementSoustraitance;
use LV\LocationBundle\Entity\Soustraitance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paiementsoustraitance controller.
 *
 */
class PaiementSoustraitanceController extends Controller
{
    /**
     * Lists all paiementSoustraitance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paiementSoustraitances = $em->getRepository('LocationBundle:PaiementSoustraitance')->findAll();

        return $this->render('paiementsoustraitance/index.html.twig', array(
            'paiementSoustraitances' => $paiementSoustraitances,
        ));
    }

    /**
     * Creates a new paiementSoustraitance entity.
     *
     */
    public function newAction(Request $request, $id, $date)
    {
        $paiementSoustraitance = new Paiementsoustraitance();
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Soustraitance');
        $s = $objectsRepository->findOneById($id);
        $paiementSoustraitance->setMontant($s->getMontantMensuel());
        $paiementSoustraitance->setDate(new \DateTime($date));
        $paiementSoustraitance->setRefSoustraitance($s);
        $form = $this->createForm('LV\LocationBundle\Form\PaiementSoustraitanceType', $paiementSoustraitance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(($s->getMontantPaye()+$s->getMontantMensuel())>=$s->getMontantTotal() or ($s->getNbrePayRestant()-1 == 0)){

            $query = $em->getRepository(Soustraitance::class)->createQueryBuilder('')
            ->update(Soustraitance::class, 'd')
            ->set('d.montantPaye', ':mp')
            ->set('d.montantRestant', ':mr')
            ->set('d.nbrePayRestant', ':npr')
            ->set('d.etat', ':etat')
            ->where('d.id = :id')
            ->setParameter('mp', $s->getMontantTotal())
            ->setParameter('mr', 0)
            ->setParameter('npr', 0)
            ->setParameter('etat', 'Payée')
            ->setParameter('id', $id)
            ->getQuery();
            $result = $query->execute();
                $em->persist($paiementSoustraitance);
                $em->flush();

            }else{
            $query = $em->getRepository(Soustraitance::class)->createQueryBuilder('')
            ->update(Soustraitance::class, 'd')
            ->set('d.montantPaye', ':mp')
            ->set('d.montantRestant', ':mr')
            ->set('d.nbrePayRestant', ':npr')
            ->where('d.id = :id')
            ->setParameter('mp', $s->getMontantPaye()+$s->getMontantMensuel())
            ->setParameter('mr', $s->getMontantRestant()-$s->getMontantMensuel())
            ->setParameter('npr', $s->getNbrePayRestant()-1)
            ->setParameter('id', $id)
            ->getQuery();
            $result = $query->execute();
                 $em->persist($paiementSoustraitance);
                 $em->flush();
            }
           

            return $this->redirectToRoute('soustraitance_detail', array('id' => $id));
        }

        return $this->render('paiementsoustraitance/new.html.twig', array(
            'paiementSoustraitance' => $paiementSoustraitance,
            'form' => $form->createView(),
            'soustraitance' => $s,
            'stcid' => $id,
        ));
    }

    public function annulerAction(Request $request, $id, $date)
    {
    
        $objectsRepository2 = $this->getDoctrine()->getRepository('LocationBundle:Soustraitance');
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:PaiementSoustraitance');
        $p= $objectsRepository->findOneByRefSoustraitance($id);
        $s = $objectsRepository2->findOneById($id);
       
            $em = $this->getDoctrine()->getManager();
            //if(($s->getMontantPaye()+$s->getMontantMensuel())>=$s->getMontantTotal())
            if($s->getMontantPaye()-$s->getMontantMensuel()>1){
            $query = $em->getRepository(Soustraitance::class)->createQueryBuilder('')
            ->update(Soustraitance::class, 'd')
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
                $query = $em->getRepository(Soustraitance::class)->createQueryBuilder('')
            ->update(Soustraitance::class, 'd')
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


            $rep2 = $em->getRepository(PaiementSoustraitance::class);
            $res = $rep2->createQueryBuilder('d')
             ->delete()
             ->where('d.date = :date and d.refSoustraitance = :refSoustraitance')
             ->setParameter('date', new \DateTime($date))
             ->setParameter('refSoustraitance', $s)
             ->getQuery()
            ->execute();
            //$em->remove($reservation);
            $em->flush();

            
            return $this->redirectToRoute('soustraitance_detail', array('id' => $id));

    }

    /**
     * Finds and displays a paiementSoustraitance entity.
     *
     */
    public function showAction(PaiementSoustraitance $paiementSoustraitance)
    {
        $deleteForm = $this->createDeleteForm($paiementSoustraitance);

        return $this->render('paiementsoustraitance/show.html.twig', array(
            'paiementSoustraitance' => $paiementSoustraitance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paiementSoustraitance entity.
     *
     */
    public function editAction(Request $request, PaiementSoustraitance $paiementSoustraitance)
    {
        $deleteForm = $this->createDeleteForm($paiementSoustraitance);
        $editForm = $this->createForm('LV\LocationBundle\Form\PaiementSoustraitanceType', $paiementSoustraitance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiementsoustraitance_edit', array('id' => $paiementSoustraitance->getId()));
        }

        return $this->render('paiementsoustraitance/edit.html.twig', array(
            'paiementSoustraitance' => $paiementSoustraitance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paiementSoustraitance entity.
     *
     */
    public function deleteAction(Request $request, PaiementSoustraitance $paiementSoustraitance)
    {
        $form = $this->createDeleteForm($paiementSoustraitance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paiementSoustraitance);
            $em->flush();
        }

        return $this->redirectToRoute('paiementsoustraitance_index');
    }

    /**
     * Creates a form to delete a paiementSoustraitance entity.
     *
     * @param PaiementSoustraitance $paiementSoustraitance The paiementSoustraitance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PaiementSoustraitance $paiementSoustraitance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paiementsoustraitance_delete', array('id' => $paiementSoustraitance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
