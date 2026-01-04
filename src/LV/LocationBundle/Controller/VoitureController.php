<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Marque;
use LV\LocationBundle\Entity\Modele;
use LV\LocationBundle\Entity\Soustraitance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use LV\LocationBundle\Form\VoitureType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Voiture controller.
 *
 */
class VoitureController extends Controller
{
   /**
     * Returns a JSON string with the neighborhoods of the City with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function listModelesOfMarqueAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $modelesRepository = $em->getRepository('LocationBundle:Modele');
        
        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $modeles = $modelesRepository->createQueryBuilder("q")
            ->where("q.marque = :marqueid")
            ->setParameter("marqueid", $request->query->get("marqueid"))
            ->getQuery()
            ->getResult();
        
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($modeles as $modele){
            $responseArray[] = array(
                "id" => $modele->getId(),
                "nom" => $modele->getNom()
            );
        }
        
        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }



    // Rest of your original controller



    /**
     * Lists all voiture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $query = $repository->createQueryBuilder('v')
            ->select('v')
            ->where('v.etat = :etat and v.disponibilite = true')
            ->setParameter('etat', 'Location')
            ->getQuery();
        $voitures = $query->getResult();

        $this->get('logger')->debug(var_export($voitures, true));

        // return $this->render('voiture/index.html.twig', array(
        //     'voitures' => $voitures,
        // ));

        $today = new \DateTime();
        $voituresData = [];

        foreach ($voitures as $voiture) {
            $datePremierPay = $voiture->getDatePremierPay();
            $dateDernierPay = $voiture->getDateDernierPay();
            $mensuel = $voiture->getMontantMensuel();
            $montantTotal = $voiture->getMontantTotal();
            $montantPayee = 0;
            $montantRestant = 0;
        
            if ($datePremierPay && $dateDernierPay) {
                if ($today > $dateDernierPay) {
                    // Tous les paiements sont supposés avoir été effectués
                    $montantPayee = $montantTotal;
                    $montantRestant = 0;
                } else {
                    $interval = $datePremierPay->diff($today);
                    $nbMonths = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0);
                    $montantPayee = $nbMonths * $mensuel;
                    $montantPayee = min($montantPayee, $montantTotal); // ne jamais dépasser le total
                    $montantRestant = max(0, $montantTotal - $montantPayee);
                }
            }
        
            $voituresData[] = [
                'voiture' => $voiture,
                'montantPayee' => $montantPayee,
                'montantRestant' => $montantRestant,
            ];
        }
        
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voituresData,
        ]);
    }

    public function index2Action()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $query = $repository->createQueryBuilder('v')
            ->select('v')
            ->where('v.etat = :etat')
            ->andwhere('NOT EXISTS (SELECT s FROM LV\LocationBundle\Entity\Soustraitance s WHERE v = s.refVoiture AND s.montantPaye >= s.montantTotal )')
            ->andwhere('v.disponibilite = true')
            ->setParameter('etat', 'Soustraitance')
            ->getQuery();
        $voitures = $query->getResult();

        $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
        $query2 = $repository2->createQueryBuilder('v')
            ->select('v')
            ->where('v.etat = :etat')
            ->andwhere('EXISTS (SELECT s FROM LV\LocationBundle\Entity\Soustraitance s WHERE v = s.refVoiture AND s.montantPaye < s.montantTotal AND s.montantPaye >= 0 )')
            ->andwhere('v.disponibilite = true')
            ->setParameter('etat', 'Soustraitance')
            ->getQuery();
        $soustraitances = $query2->getResult();

        return $this->render('voiture/index2.html.twig', array(
            'voitures' => $voitures,
            'soustraitances' => $soustraitances,
        ));
    }

    /**
     * Creates a new voiture entity.
     *
     */
    public function newAction(Request $request)
    {
        $voiture = new Voiture();
        $marque = new Marque();
        $modele = new Modele();
        $voiture->setDisponibilite(true);

         $form2 = $this->createForm('LV\LocationBundle\Form\MarqueType', $marque);
         $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();

         $voiture->setMarque($marque);
            
        }

        $form3 = $this->createForm('LV\LocationBundle\Form\ModeleType', $modele);
         $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();

         $voiture->setModele($modele);
         $voiture->setMarque($modele->getMarque());
            
        }
        $form = $this->createForm('LV\LocationBundle\Form\VoitureType', $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $voiture->getPhoto();
            if($file != null){
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $voiture->setPhoto($fileName);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute('voiture_index', array('id' => $voiture->getId()));
        }

        return $this->render('voiture/new.html.twig', array(
            'voiture' => $voiture,
            'form' => $form->createView(),
             'form_marque' => $form2->createView(),
             'form_modele' => $form3->createView(),
        ));
    }

    /**
     * Finds and displays a voiture entity.
     *
     */
    public function showAction(Request $request, Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);

        $showForm = $this->createForm('LV\LocationBundle\Form\VoitureType', $voiture);
        $showForm->handleRequest($request);
        return $this->render('voiture/show.html.twig', array(
            'voiture' => $voiture,
    //        'show_form' => $showForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing voiture entity.
     *
     */
    public function editAction(Request $request, Voiture $voiture)
    {
        $photo=$voiture->getPhoto();
        if($photo !== null) {
        $voiture->setPhoto(new File($this->getParameter('images_directory').'/'.$photo));
        }
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($voiture);
        $editForm = $this->createForm('LV\LocationBundle\Form\VoitureType', $voiture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
           
            //Check if new image was uploaded
            if($voiture->getPhoto() !== null) {
            //Type hint
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $newImage*/
            $file=$voiture->getPhoto();
            $newImageName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'), $newImageName);
            $voiture->setPhoto($newImageName);
        } else {
            //Restore old file name
            $voiture->setPhoto($photo);
        }

        $em->flush();

            return $this->redirectToRoute('voiture_index', array('id' => $voiture->getId()));
        }

        return $this->render('voiture/edit.html.twig', array(
            'voiture' => $voiture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a voiture entity.
     *
     */
    public function deleteAction(Request $request, Voiture $voiture)
    {
        $em = $this->getDoctrine()->getManager();
        if ($voiture->getDisponibilite() == true ) {
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.disponibilite', ':disponibilite')
            ->where('v.id = :id')
            ->setParameter('disponibilite', false)
            ->setParameter('id', $voiture->getId())
            ->getQuery();
            $result = $query->execute();
            $em->flush();

            return $this->redirectToRoute('voiture_index');
        } 
        else {
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.disponibilite', ':disponibilite')
            ->where('v.id = :id')
            ->setParameter('disponibilite', true)
            ->setParameter('id', $voiture->getId())
            ->getQuery();
            $result = $query->execute();
            $em->flush();
            //return $this->redirectToRoute('vehicule_deleted');
        };
    }

    public function delete1Action(Request $request, Voiture $voiture)
    {
        $em = $this->getDoctrine()->getManager();
        if ($voiture->getDisponibilite() == true ) {
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.disponibilite', ':disponibilite')
            ->where('v.id = :id')
            ->setParameter('disponibilite', false)
            ->setParameter('id', $voiture->getId())
            ->getQuery();
            $result = $query->execute();
            $em->flush();

            return $this->redirectToRoute('voiture_index2');
            } 
            else {
            $query = $em->getRepository(Voiture::class)->createQueryBuilder('')
            ->update(Voiture::class, 'v')
            ->set('v.disponibilite', ':disponibilite')
            ->where('v.id = :id')
            ->setParameter('disponibilite', true)
            ->setParameter('id', $voiture->getId())
            ->getQuery();
            $result = $query->execute();
            $em->flush();
            //return $this->redirectToRoute('vehicule_deleted');
            };
    }

    /**
     * Creates a form to delete a voiture entity.
     *
     * @param Voiture $voiture The voiture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Voiture $voiture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('voiture_delete', array('id' => $voiture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
