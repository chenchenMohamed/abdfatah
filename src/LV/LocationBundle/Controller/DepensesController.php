<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Depenses;
use LV\LocationBundle\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

/**
 * Depense controller.
 *
 */
class DepensesController extends Controller
{
    /**
     * Lists all depense entities.
     *
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder(null, [
            'method' => 'GET',
            'csrf_protection' => false,
        ])
        ->add('voiture', EntityType::class, [
            'class' => 'LocationBundle:Voiture',
            'choice_label' => 'matricule',
            'placeholder' => 'Sélectionner une voiture',
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('v')
                    ->where('v.disponibilite = :disponible')
                    ->setParameter('disponible', true);
            },
        ])
        ->getForm();

        // ⚡ Important pour peupler $form->getData()
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('LocationBundle:Depenses');

        $qb = $repo->createQueryBuilder('d');

        $data = $form->getData();

        if (!empty($data['voiture'])) {
            $qb->andWhere('d.refVoiture = :voiture')
            ->setParameter('voiture', $data['voiture']->getId());
        }

        $depenses = $qb->getQuery()->getResult();

        return $this->render('depenses/index.html.twig', [
            'depenses' => $depenses,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Creates a new depense entity.
     *
     */
    public function newAction(Request $request)
    {
        $depense = new Depenses();
        
$em2= $this->getDoctrine()->getManager();
            $c = $em2->getRepository(Depenses::class)->findOneBy(array(), array('id' => 'desc'));
          //  var_dump($c);
            $datec = date('Y');
            //var_dump($date);
            if ($c == null)
            {
              $cnum='1'."/".$datec;
              $depense->setCodeDepense($cnum); 
        //        $contrats->setRefReservation($reservation->setId($ccid));   
            }
            else
            {   
                $resc = substr($c->getCodeDepense(), 3, 4);
                $resc = (int) $resc;
                $date1c = (int) $datec;
                if($date1c<$resc)
                {
                $cid=$c->getId();
                $cnum=($cid-($cid-1))."/".$datec;
                $depense->setCodeDepense($cnum);  
             //   $contrats->setRefReservation($reservation->setId($ccid));  

                }else
                {
                $cid=$c->getId();
                $cnum=($cid+1)."/".$datec;
                $depense->setCodeDepense($cnum);  
              //  $contrats->setRefReservation($reservation->setId($ccid));  
                };
               
            };

        $form = $this->createForm('LV\LocationBundle\Form\DepensesType', $depense);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($depense);
            $em->flush();

            $this->editTotalDepenseVoiture($depense->getRefVoiture());

            return $this->redirectToRoute('depenses_index');
        }

        return $this->render('depenses/new.html.twig', array(
            'depense' => $depense,
            'form' => $form->createView(),
            'dcode' => $cnum,
        ));
    }

    public function editTotalDepenseVoiture($idVoiture){

        $repository7 = $this->getDoctrine()->getRepository(Depenses::class);
        $query7= $repository7->createQueryBuilder('c')
            ->join('c.refVoiture', 'v')
            ->select('SUM(c.montant)')
            ->andWhere('v.id = :voitureId')
            ->setParameter('voitureId', $idVoiture);
        $depenses = $query7->getQuery()->getResult();

        if($depenses == null){$depenses = 0;};

         $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.totalDepenses', ':totalDepenses')
            ->where('v.id = :id')
            ->setParameter('totalDepenses', $depenses[0][1])
            ->setParameter('id', $idVoiture)
            ->getQuery();
            $result = $query->execute();
            $em->flush();
    }

    /**
     * Finds and displays a depense entity.
     *
     */
    public function showAction(Depenses $depense)
    {
        $deleteForm = $this->createDeleteForm($depense);

        return $this->render('depenses/show.html.twig', array(
            'depense' => $depense,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing depense entity.
     *
     */
    public function editAction(Request $request, Depenses $depense)
    {
        $deleteForm = $this->createDeleteForm($depense);
        $editForm = $this->createForm('LV\LocationBundle\Form\DepensesType', $depense);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->editTotalDepenseVoiture($depense->getRefVoiture());

            return $this->redirectToRoute('depenses_index');
        }

        return $this->render('depenses/edit.html.twig', array(
            'depense' => $depense,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a depense entity.
     *
     */
    public function deleteAction(Request $request, Depenses $depense)
    {
        $form = $this->createDeleteForm($depense);
        $form->handleRequest($request);

       
            $em = $this->getDoctrine()->getManager();
            $em->remove($depense);
            $em->flush();

            $this->editTotalDepenseVoiture($depense->getRefVoiture());

     
        return $this->redirectToRoute('depenses_index');
    }

    /**
     * Creates a form to delete a depense entity.
     *
     * @param Depenses $depense The depense entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Depenses $depense)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('depenses_delete', array('id' => $depense->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
