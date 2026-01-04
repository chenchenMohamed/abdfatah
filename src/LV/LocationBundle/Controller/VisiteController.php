<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Visite controller.
 *
 */
class VisiteController extends Controller
{
    
    /**
     * Lists all visite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $visites = $em->getRepository('LocationBundle:Visite')->findAll();

        return $this->render('visite/index.html.twig', array(
            'visites' => $visites,
        ));
    }

    /**
     * Creates a new visite entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $visite = new Visite();
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository('LocationBundle:Voiture')->findOneById($id);
        $visite->setRefVoiture($vehicule);

        $form = $this->createForm('LV\LocationBundle\Form\VisiteType', $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visite);
            $em->flush();

            return $this->redirectToRoute('entretien', array('id' => $visite->getRefVoiture()->getId()));
        }

        return $this->render('visite/new.html.twig', array(
            'visite' => $visite,
            'form' => $form->createView(),
            'id' => $id,
            'matricule' => $visite->getRefVoiture()->getMatricule(),
        ));
    }

    /**
     * Creates a new visite entity.
     *
     */
    public function new1Action(Request $request,$voiture)
    {//var_dump($voiture);
        $visite = new Visite();
        $em = $this->getDoctrine()->getManager();
        $veh = $em->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);
        $visite->setRefVoiture($veh);
        $form = $this->createForm('LV\LocationBundle\Form\VisiteType', $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visite);
            $em->flush();

            return $this->redirectToRoute('entretien1', array('voiture' => $voiture));
        }

        return $this->render('visite/new1.html.twig', array(
            'visite' => $visite,
            'form' => $form->createView(),
            'matricule' => $voiture,
        ));
    }
	
    public function new2Action(Request $request,$voiture)
    {//var_dump($voiture);
        $visite = new Visite();
        $em = $this->getDoctrine()->getManager();
        $veh = $em->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);
        $visite->setRefVoiture($veh);
        $form = $this->createForm('LV\LocationBundle\Form\VisiteType', $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visite);
            $em->flush();

            return $this->redirectToRoute('entretien1', array('voiture' => $voiture));
        }

        return $this->render('visite/new1.html.twig', array(
            'visite' => $visite,
            'form' => $form->createView(),
            'voiture' => $voiture,
        ));
    }

    /**
     * Finds and displays a visite entity.
     *
     */
    public function showAction(Visite $visite)
    {
        $deleteForm = $this->createDeleteForm($visite);

        return $this->render('visite/show.html.twig', array(
            'visite' => $visite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing visite entity.
     *
     */
    public function editAction(Request $request, Visite $visite)
    {
        $deleteForm = $this->createDeleteForm($visite);
        $editForm = $this->createForm('LV\LocationBundle\Form\VisiteType', $visite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entretien', array('id' => $visite->getRefVoiture()->getId()));
        }

        return $this->render('visite/edit.html.twig', array(
            'visite' => $visite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id' => $visite->getRefVoiture()->getId(),
            'matricule' => $visite->getRefVoiture()->getMatricule(),
        ));
    }

    /**
     * Deletes a visite entity.
     *
     */
    public function deleteAction(Request $request, Visite $visite)
    {
        $form = $this->createDeleteForm($visite);
        $form->handleRequest($request);

        
            $em = $this->getDoctrine()->getManager();
            $em->remove($visite);
            $em->flush();
        

        return $this->redirectToRoute('entretien', array('id' => $visite->getRefVoiture()->getId()));
    }

    /**
     * Creates a form to delete a visite entity.
     *
     * @param Visite $visite The visite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Visite $visite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visite_delete', array('id' => $visite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
