<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Client controller.
 *
 */
class ClientController extends Controller
{
    /**
     * Lists all client entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('LocationBundle:Client')->findByDisponibilite(true);

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }

    public function listeNoirAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(Client::class);
        $query = $repository->createQueryBuilder('c')
            ->select('c')
            ->where('c.disponibilite = true and c.degat = true')
            ->getQuery();
        $clients = $query->getResult();

        return $this->render('client/index2.html.twig', array(
            'clients' => $clients,
            
        ));
    }

    /**
     * Creates a new client entity.
     *
     */
    public function newAction(Request $request)
    {
        $client = new Client();
        $client->setDisponibilite(true);
        $form = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_index', array('id' => $client->getId()));
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     */
    public function showAction(Request $request, Client $client)
    {
        $showForm = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
        $showForm->handleRequest($request);
         return $this->render('client/show.html.twig', array(
            'client' => $client,
            'show_form' => $showForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     */
    public function editAction(Request $request, Client $client)
    {
        //$client->setCause('  ');
        $editForm = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index', array('id' => $client->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function edit2Action(Request $request, Client $client)
    {
        //$client->setCause('  ');
        $editForm = $this->createForm('LV\LocationBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_liste_noir', array('id' => $client->getId()));
        }

        return $this->render('client/edit2.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
        ));
    }


    /**
     * Deletes a client entity.
     *
     */
    public function deleteAction(Request $request, Client $client)
    {
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Client::class)->createQueryBuilder('')
            ->update(Client::class, 'c')
            ->set('c.disponibilite', ':disponibilite')
            ->where('c.id = :id')
            ->setParameter('disponibilite', false)
            ->setParameter('id', $client->getId())
            ->getQuery();
            $result = $query->execute();
            $em->flush();
        

        return $this->redirectToRoute('client_index');
    }

    public function delete1Action(Request $request, Client $client)
    {
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Client::class)->createQueryBuilder('')
            ->update(Client::class, 'c')
            ->set('c.disponibilite', ':disponibilite')
            ->where('c.id = :id')
            ->setParameter('disponibilite', false)
            ->setParameter('id', $client->getId())
            ->getQuery();
            $result = $query->execute();
            $em->flush();
        

        return $this->redirectToRoute('client_liste_noir');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
