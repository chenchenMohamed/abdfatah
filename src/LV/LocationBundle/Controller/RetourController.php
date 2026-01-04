<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Retour;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\LocationBundle\Entity\Client;
use LV\LocationBundle\Entity\Voiture;

/**
 * Retour controller.
 *
 */
class RetourController extends Controller
{
    /**
     * Lists all retour entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $retours = $em->getRepository('LocationBundle:Retour')->findAll();

        return $this->render('retour/index.html.twig', array(
            'retours' => $retours,
        ));
    }

    /**
     * Creates a new retour entity.
     *
     */
    public function newAction(Request $request)
    {
        $retour = new Retour();
        $form = $this->createForm('LV\LocationBundle\Form\RetourType', $retour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($retour);
            $em->flush();
            return $this->redirectToRoute('csr_index', array('id' => $retour->getId()));
        }

        return $this->render('retour/new.html.twig', array(
            'retour' => $retour,
            'form' => $form->createView(),
        ));
    }


    public function new1Action(Request $request, $id)
    {
        $retour = new Retour();
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:Contrat');
        $c = $objectsRepository->findOneById($id);
        $retour->setRefContrat($c);
		$refcontrat=$c->getNumContrat();
		$refclient=$c->getConducteur1();
		$refvoiture=$c->getRefReservation()->getRefVoiture();
        $retour->setRefClient($c->getRefReservation()->getRefClient());
        $retour->setRefVoiture($c->getRefReservation()->getRefVoiture());
        $form = $this->createForm('LV\LocationBundle\Form\RetourType', $retour);
        $form->handleRequest($request);
        $km = $request->get('lv_locationbundle_retour')['km'];
        $degats = $request->get('lv_locationbundle_retour')['degats']; 
        $etatRetour = $request->get('lv_locationbundle_retour')['etatRetour'];

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($degats == 0){
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.km', ':km')
            ->where('v.matricule = :matricule')
            ->setParameter('km', $km)
            ->setParameter('matricule', $c->getRefReservation()->getRefVoiture()->getMatricule())
            ->getQuery();
            $result = $query->execute();
            $em->persist($retour);
            $em->flush();
            }else{
            $query2 = $em->getRepository(Client::class)->createQueryBuilder('')
            ->update(Client::class, 'c')
            ->set('c.degat', ':degat')
            ->set('c.cause', ':cause')
            ->where('c.id = :id')
            ->setParameter('degat', $degats)
            ->setParameter('cause', $etatRetour)
            ->setParameter('id', $c->getRefReservation()->getRefClient()->getId())
            ->getQuery();
            $result2 = $query2->execute();

            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.km', ':km')
            ->where('v.matricule = :matricule')
            ->setParameter('km', $km)
            ->setParameter('matricule', $c->getRefReservation()->getRefVoiture()->getMatricule())
            ->getQuery();
            $result = $query->execute();
            $em->persist($retour);
            $em->flush();
            }

            return $this->redirectToRoute('csr_index', array('id' => $retour->getId()));
        }

        return $this->render('retour/new1.html.twig', array(
            'retour' => $retour,
            'form' => $form->createView(),
            'refclient' => $refclient,
            'refvoiture' => $refvoiture,
            'refcontrat' => $refcontrat,
        ));
    }

    public function new2Action(Request $request, $id)
    {
        $retour = new Retour();
        $objectsRepository = $this->getDoctrine()->getRepository('LocationBundle:CSR');
        $c = $objectsRepository->findOneById($id);
        $retour->setRefCsr($c);
		$refcsr=$c->getNumContrat();
		$refclient=$c->getConducteur1();
		$refvoiture=$c->getRefVoiture();
        $retour->setRefClient($c->getConducteur1());
        $retour->setRefVoiture($c->getRefVoiture());
        $form = $this->createForm('LV\LocationBundle\Form\RetourType', $retour);
        $form->handleRequest($request);
        $km = $request->get('lv_locationbundle_retour')['km'];
        $degats = $request->get('lv_locationbundle_retour')['degats'];
        $etatRetour = $request->get('lv_locationbundle_retour')['etatRetour'];

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($degats == 0){
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.km', ':km')
            ->where('v.matricule = :matricule')
            ->setParameter('km', $km)
            ->setParameter('matricule', $c->getRefVoiture()->getMatricule())
            ->getQuery();
            $result = $query->execute();
            $em->persist($retour);
            $em->flush();
            }else{
            $query2 = $em->getRepository(Client::class)->createQueryBuilder('')
            ->update(Client::class, 'c')
            ->set('c.degat', ':degat')
            ->where('c.id = :id')
            ->set('c.cause', ':cause')
            ->setParameter('degat', $degats)
            ->setParameter('cause', $etatRetour)
            ->setParameter('id', $c->getConducteur1()->getId())
            ->getQuery();
            $result2 = $query2->execute();

            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.km', ':km')
            ->where('v.matricule = :matricule')
            ->setParameter('km', $km)
            ->setParameter('matricule', $c->getRefVoiture()->getMatricule())
            ->getQuery();
            $result = $query->execute();
            $em->persist($retour);
            $em->flush();
            }

            return $this->redirectToRoute('retour_index', array('id' => $retour->getId()));
        }

        return $this->render('retour/new2.html.twig', array(
            'retour' => $retour,
            'form' => $form->createView(),
            'refclient' => $refclient,
            'refvoiture' => $refvoiture,
            'refcsr' => $refcsr,
        ));
    }

    /**
     * Finds and displays a retour entity.
     *
     */
    public function showAction(Retour $retour)
    {
        $deleteForm = $this->createDeleteForm($retour);

        return $this->render('retour/show.html.twig', array(
            'retour' => $retour,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing retour entity.
     *
     */
    public function editAction(Request $request, Retour $retour)
    {
        $deleteForm = $this->createDeleteForm($retour);
        $editForm = $this->createForm('LV\LocationBundle\Form\RetourType', $retour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('retour_edit', array('id' => $retour->getId()));
        }

        return $this->render('retour/edit.html.twig', array(
            'retour' => $retour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a retour entity.
     *
     */
    public function deleteAction(Request $request, Retour $retour)
    {
        $form = $this->createDeleteForm($retour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($retour);
            $em->flush();
        }

        return $this->redirectToRoute('retour_index');
    }

    /**
     * Creates a form to delete a retour entity.
     *
     * @param Retour $retour The retour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Retour $retour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('retour_delete', array('id' => $retour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
