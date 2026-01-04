<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Modele;
use LV\LocationBundle\Entity\Marque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Modele controller.
 *
 */
class ModeleController extends Controller
{
    /**
     * Lists all modele entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modeles = $em->getRepository('LocationBundle:Modele')->findAll();

        return $this->render('modele/index.html.twig', array(
            'modeles' => $modeles,
        ));
    }

    /**
     * Creates a new modele entity.
     *
     */
    public function newAction(Request $request)
    {
        $modele = new Modele();
        $marque = new Marque();

         $form2 = $this->createForm('LV\LocationBundle\Form\MarqueType', $marque);
         $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();

         $modele->setMarque($marque);
            
        }

        $form = $this->createForm('LV\LocationBundle\Form\ModeleType', $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();

            return $this->redirectToRoute('modele_index', array('id' => $modele->getId()));
        }

        return $this->render('modele/new.html.twig', array(
            'modele' => $modele,
            'form' => $form->createView(),
            'form_marque' => $form2->createView(),
        ));
    }

    /**
     * Finds and displays a modele entity.
     *
     */
    public function showAction(Modele $modele)
    {
        $deleteForm = $this->createDeleteForm($modele);

        return $this->render('modele/show.html.twig', array(
            'modele' => $modele,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing modele entity.
     *
     */
    public function editAction(Request $request, Modele $modele)
    {
        $deleteForm = $this->createDeleteForm($modele);
        $editForm = $this->createForm('LV\LocationBundle\Form\ModeleType', $modele);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modele_index', array('id' => $modele->getId()));
        }

        return $this->render('modele/edit.html.twig', array(
            'modele' => $modele,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a modele entity.
     *
     */
    public function deleteAction(Request $request, Modele $modele)
    {
        $form = $this->createDeleteForm($modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($modele);
            $em->flush();
        }

        return $this->redirectToRoute('modele_index');
    }

    /**
     * Creates a form to delete a modele entity.
     *
     * @param Modele $modele The modele entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modele $modele)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modele_delete', array('id' => $modele->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
