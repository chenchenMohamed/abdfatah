<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\TypeDepenses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Depense controller.
 *
 */
class TypeDepensesController extends Controller
{
    /**
     * Lists all depense entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeDepenses = $em->getRepository('LocationBundle:TypeDepenses')->findAll();

        return $this->render('typedepenses/index.html.twig', array(
            'typeDepenses' => $typeDepenses,
        ));
    }

    /**
     * Creates a new depense entity.
     *
     */
    public function newAction(Request $request)
    {
        $typeDepense = new TypeDepenses();
        
        $em2= $this->getDoctrine()->getManager();
        $c = $em2->getRepository(TypeDepenses::class)->findOneBy(array(), array('id' => 'desc'));
          
        $form = $this->createForm('LV\LocationBundle\Form\TypeDepensesType', $typeDepense);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeDepense);
            $em->flush();

            return $this->redirectToRoute('typedepenses_index');
        }

        return $this->render('typedepenses/new.html.twig', array(
            'typeDepense' => $typeDepense,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a depense entity.
     *
     */
    public function showAction(TypeDepenses $typeDepense)
    {
        $deleteForm = $this->createDeleteForm($typeDepense);

        return $this->render('typedepenses/show.html.twig', array(
            'typeDepense' => $typeDepense,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing depense entity.
     *
     */
    public function editAction(Request $request, TypeDepenses $typeDepense)
    {
        $deleteForm = $this->createDeleteForm($typeDepense);
        $editForm = $this->createForm('LV\LocationBundle\Form\TypeDepensesType', $typeDepense);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typedepenses_index');
        }

        return $this->render('typedepenses/edit.html.twig', array(
            'typeDepense' => $typeDepense,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a depense entity.
     *
     */
    public function deleteAction(Request $request, TypeDepenses $typeDepense)
    {
        $em = $this->getDoctrine()->getManager();

        // Récupérer toutes les dépenses liées à ce type
        $depenses = $em->getRepository('LocationBundle:Depenses')
            ->createQueryBuilder('d')
            ->where('d.refTypeDepense = :refTypeDepense')
            ->setParameter('refTypeDepense', $typeDepense->getId())
            ->getQuery()
            ->getResult();

        // Vérifier si ce type contient des dépenses
        if (count($depenses) > 0) {
            $this->addFlash('error', 'Ce type contient des dépenses, vous ne pouvez pas le supprimer.');
            return $this->redirectToRoute('typedepenses_index');
        }

        // Suppression si aucune dépense n'est liée
        $em->remove($typeDepense);
        $em->flush();

        $this->addFlash('success', 'Type de dépense supprimé avec succès.');
        return $this->redirectToRoute('typedepenses_index');
    }

    /**
     * Creates a form to delete a depense entity.
     *
     * @param TypeDepenses $depense The depense entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeDepenses $typeDepense)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typedepenses_delete', array('id' => $typeDepense->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
