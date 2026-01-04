<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Vidange;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vidange controller.
 *
 */
class VidangeController extends Controller
{
    /**
     * Lists all vidange entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vidanges = $em->getRepository('LocationBundle:Vidange')->findAll();

        return $this->render('vidange/index.html.twig', array(
            'vidanges' => $vidanges,
        ));
    }

    /**
     * Creates a new vidange entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $vidange = new Vidange();
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository('LocationBundle:Voiture')->findOneById($id);
        $vidange->setRefVoiture($vehicule);
        $vidange->setCompteur($vehicule->getKm());


        $form = $this->createForm('LV\LocationBundle\Form\VidangeType', $vidange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vidange);
            $em->flush();

            return $this->redirectToRoute('entretien', array('id' => $vidange->getRefVoiture()->getId()));
        }

        return $this->render('vidange/new.html.twig', array(
            'vidange' => $vidange,
            'form' => $form->createView(),
            'id' => $id,
            'matricule' => $vidange->getRefVoiture()->getMatricule(),
        ));
    }
    
/**
     * Creates a new vidange entity.
     *
     */
    public function new1Action(Request $request,$voiture)
    {//var_dump($voiture);
        $vidange = new Vidange();
        $em = $this->getDoctrine()->getManager();
        $veh = $em->getRepository('LocationBundle:Voiture')->findOneByMatricule($voiture);
        $vidange->setRefVoiture($veh);
		$vidange->setCompteur($veh->getKm());
        $form = $this->createForm('LV\LocationBundle\Form\VidangeType', $vidange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vidange);
            $em->flush();

            return $this->redirectToRoute('entretien1', array('voiture' => $voiture));
        }

        return $this->render('vidange/new1.html.twig', array(
            'vidange' => $vidange,
            'form' => $form->createView(),
			'matricule'=>$voiture,
        ));
    }

    /**
     * Finds and displays a vidange entity.
     *
     */
    public function showAction(Vidange $vidange)
    {
        $deleteForm = $this->createDeleteForm($vidange);

        return $this->render('vidange/show.html.twig', array(
            'vidange' => $vidange,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vidange entity.
     *
     */
    public function editAction(Request $request, Vidange $vidange)
    {
        $deleteForm = $this->createDeleteForm($vidange);
        $editForm = $this->createForm('LV\LocationBundle\Form\VidangeType', $vidange);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entretien', array('id' => $vidange->getRefVoiture()->getId()));
        }

        return $this->render('vidange/edit.html.twig', array(
            'vidange' => $vidange,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id' => $vidange->getRefVoiture()->getId(),
            'matricule' => $vidange->getRefVoiture()->getMatricule(),
        ));
    }

    /**
     * Deletes a vidange entity.
     *
     */
    public function deleteAction(Request $request, Vidange $vidange)
    {
        $form = $this->createDeleteForm($vidange);
        $form->handleRequest($request);

      
            $em = $this->getDoctrine()->getManager();
            $em->remove($vidange);
            $em->flush();
        

         return $this->redirectToRoute('entretien', array('id' => $vidange->getRefVoiture()->getId()));
    }

    /**
     * Creates a form to delete a vidange entity.
     *
     * @param Vidange $vidange The vidange entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vidange $vidange)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vidange_delete', array('id' => $vidange->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
