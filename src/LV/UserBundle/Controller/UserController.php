<?php

namespace LV\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LV\UserBundle\Entity\User;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
     /**
     * Lists all Users.
     *
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }


    public function editAction(Request $request, User $id)
    {

        $editForm = $this->createForm('LV\UserBundle\Form\UserType', $id);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', array(
            'article' => $id,
            'edit_form' => $editForm->createView(),

        ));
    }

    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneById($user->getId());

        if (!$user) {
        throw $this->createNotFoundException('Unable to find entity.');
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }

    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}