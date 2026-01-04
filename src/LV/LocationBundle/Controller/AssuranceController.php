<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Assurance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Assurance controller.
 *
 */
class AssuranceController extends Controller
{
    /**
     * Lists all assurance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $assurances = $em->getRepository('LocationBundle:Assurance')->findAll();

        return $this->render('assurance/index.html.twig', array(
            'assurances' => $assurances,
        ));
    }

    /**
     * Creates a new assurance entity.
     *
     */
    public function newAction(Request $request)
    {
        $assurance = new Assurance();
        $form = $this->createForm('LV\LocationBundle\Form\AssuranceType', $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assurance);
            $em->flush();

            return $this->redirectToRoute('assurance_index');
        }

        return $this->render('assurance/new.html.twig', array(
            'assurance' => $assurance,
            'form' => $form->createView(),
        ));
    }

    public function new1Action(Request $request,$num)
    {
        $assurance = new Assurance();	
        $em = $this->getDoctrine()->getManager();	
        $assurances = $em->getRepository('LocationBundle:Assurance')->findOneByNumAssurance($num);
		$assurance->setNomAssurance($assurances->getNomAssurance());
        $form = $this->createForm('LV\LocationBundle\Form\AssuranceType', $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assurance);
            $em->flush();

            return $this->redirectToRoute('assurance_index');
        }

        return $this->render('assurance/new.html.twig', array(
            'assurance' => $assurance,
            'form' => $form->createView(),
        ));
    }
	
    /**
     * Finds and displays a assurance entity.
     *
     */
    public function showAction(Assurance $assurance)
    {
        $deleteForm = $this->createDeleteForm($assurance);

        return $this->render('assurance/show.html.twig', array(
            'assurance' => $assurance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing assurance entity.
     *
     */
    public function editAction(Request $request, Assurance $assurance)
    {
        $deleteForm = $this->createDeleteForm($assurance);
        $editForm = $this->createForm('LV\LocationBundle\Form\AssuranceType', $assurance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('assurance_index');
        }

        return $this->render('assurance/edit.html.twig', array(
            'assurance' => $assurance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a assurance entity.
     *
     */
    public function deleteAction(Request $request, Assurance $assurance)
    {
        $form = $this->createDeleteForm($assurance);
        $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->remove($assurance);
            $em->flush();
        

        return $this->redirectToRoute('assurance_index');
    }

    /**
     * Creates a form to delete a assurance entity.
     *
     * @param Assurance $assurance The assurance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Assurance $assurance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('assurance_delete', array('id' => $assurance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
