<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Cheque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cheque controller.
 *
 */
class ChequeController extends Controller
{
    /**
     * Lists all cheque entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cheques = $em->getRepository('LocationBundle:Cheque')->findAll();

        return $this->render('cheque/index.html.twig', array(
            'cheques' => $cheques,
        ));
    }

    /**
     * Creates a new cheque entity.
     *
     */
    public function newAction(Request $request)
    {
        $cheque = new Cheque();
        $form = $this->createForm('LV\LocationBundle\Form\ChequeType', $cheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cheque);
            $em->flush();

            return $this->redirectToRoute('cheque_show', array('id' => $cheque->getId()));
        }

        return $this->render('cheque/new.html.twig', array(
            'cheque' => $cheque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cheque entity.
     *
     */
    public function showAction(Cheque $cheque)
    {
        $deleteForm = $this->createDeleteForm($cheque);

        return $this->render('cheque/show.html.twig', array(
            'cheque' => $cheque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cheque entity.
     *
     */
    public function editAction(Request $request, Cheque $cheque)
    {
        $deleteForm = $this->createDeleteForm($cheque);
        $editForm = $this->createForm('LV\LocationBundle\Form\ChequeType', $cheque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cheque_edit', array('id' => $cheque->getId()));
        }

        return $this->render('cheque/edit.html.twig', array(
            'cheque' => $cheque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cheque entity.
     *
     */
    public function deleteAction(Request $request, Cheque $cheque)
    {
        $form = $this->createDeleteForm($cheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cheque);
            $em->flush();
        }

        return $this->redirectToRoute('cheque_index');
    }

    /**
     * Creates a form to delete a cheque entity.
     *
     * @param Cheque $cheque The cheque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cheque $cheque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cheque_delete', array('id' => $cheque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
