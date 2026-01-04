<?php

namespace LV\LocationBundle\Controller;

use LV\LocationBundle\Entity\Voiture;
use LV\LocationBundle\Entity\Visite;
use LV\LocationBundle\Entity\Vidange;
use LV\LocationBundle\Entity\Depenses;
use LV\LocationBundle\Entity\Retour;
use LV\LocationBundle\Entity\Assurance;
use LV\LocationBundle\Entity\Paiement;
use LV\LocationBundle\Entity\CSR;
use LV\LocationBundle\Entity\Disponibilite;
use LV\LocationBundle\Entity\PaiementSoustraitance;
use LV\LocationBundle\Entity\Soustraitance;
use LV\LocationBundle\Entity\Echeance;
use LV\LocationBundle\Entity\Assurance_voiture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Options;
use Dompdf\Dompdf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;


class DefaultController extends Controller
{
    public function chartAction(Request $request)
{
     $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('chart'))
        ->getForm(); 

        $annee = date('Y');
        $year = $request->get('form')['date']['year'];
        $time = $year.'-'.'1'.'-'.'1';
        if($time == '-1-1'){
            $date= new \DateTime($annee);
            $date->setTime(0, 0);
            $form->get('date')->setData($date);

            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(CSR::class);
            $query1= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '1')
                ->getQuery();
            $jan = sizeof($query1->getResult());

            $query2= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '2')
                ->getQuery();
            $fev = sizeof($query2->getResult());

            $query3= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '3')
                ->getQuery();
            $mar = sizeof($query3->getResult());

            $query4= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '4')
                ->getQuery();
            $avr = sizeof($query4->getResult());

            $query5= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '5')
                ->getQuery();
            $mai = sizeof($query5->getResult());

            $query6= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '6')
                ->getQuery();
            $juin = sizeof($query6->getResult());

            $query7= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '7')
                ->getQuery();
            $juillet = sizeof($query7->getResult());

            $query8= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '8')
                ->getQuery();
            $aout = sizeof($query8->getResult());

            $query9= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '9')
                ->getQuery();
            $sep = sizeof($query9->getResult());

            $query10= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '10')
                ->getQuery();
            $oct = sizeof($query10->getResult());

            $query11= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '11')
                ->getQuery();
            $nov = sizeof($query11->getResult());

            $query12= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $annee)
                ->setParameter('mois', '12')
                ->getQuery();
            $dec = sizeof($query12->getResult());

            $col = new ColumnChart();
            $col->getData()->setArrayToDataTable(
            [
                ['Mois', 'Nombre de contrats', ['role' => 'annotation']],
                ['Jan',  $jan, $jan],
                ['Fév',  $fev, $fev],
                ['Mar', $mar, $mar],
                ['Avr', $avr, $avr],
                ['Mai', $mai, $mai],
                ['Juin',  $juin, $juin],
                ['Juillet',  $juillet, $juillet],
                ['Août',  $aout, $aout],
                ['Sep',  $sep, $sep],
                ['Oct', $oct, $oct],
                ['Nov', $nov, $nov],
                ['Déc', $dec, $dec]
            ]
            );
            $col->getOptions()->setTitle('Nombre de contrats par mois en '.$annee);
            $col->getOptions()->getAnnotations()->setAlwaysOutside(true);
            $col->getOptions()->getAnnotations()->getTextStyle()->setFontSize(14);
            $col->getOptions()->getAnnotations()->getTextStyle()->setColor('#000');
            $col->getOptions()->getAnnotations()->getTextStyle()->setAuraColor('none');
            $col->getOptions()->getHAxis()->setTitle('Mois');
            $col->getOptions()->getHAxis()->setFormat('h:mm a');
            $col->getOptions()->getHAxis()->getViewWindow()->setMin([7, 30, 0]);
            $col->getOptions()->getHAxis()->getViewWindow()->setMax([17, 30, 0]);
            $col->getOptions()->getVAxis()->setTitle('Nombre de contrats');
            $col->getOptions()->setWidth(900);
            $col->getOptions()->setHeight(500);
        }
        else{
            $date= new \DateTime($time);
            $date->setTime(0, 0);
            $form->get('date')->setData($date);

            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(CSR::class);
            $query1= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '1')
                ->getQuery();
            $jan = sizeof($query1->getResult());

            $query2= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '2')
                ->getQuery();
            $fev = sizeof($query2->getResult());

            $query3= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '3')
                ->getQuery();
            $mar = sizeof($query3->getResult());

            $query4= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '4')
                ->getQuery();
            $avr = sizeof($query4->getResult());

            $query5= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '5')
                ->getQuery();
            $mai = sizeof($query5->getResult());

            $query6= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '6')
                ->getQuery();
            $juin = sizeof($query6->getResult());

            $query7= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '7')
                ->getQuery();
            $juillet = sizeof($query7->getResult());

            $query8= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '8')
                ->getQuery();
            $aout = sizeof($query8->getResult());

            $query9= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '9')
                ->getQuery();
            $sep = sizeof($query9->getResult());

            $query10= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '10')
                ->getQuery();
            $oct = sizeof($query10->getResult());

            $query11= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '11')
                ->getQuery();
            $nov = sizeof($query11->getResult());

            $query12= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.dateContrat) = :annee AND MONTH(c.dateContrat) = :mois')
                ->setParameter('annee', $year)
                ->setParameter('mois', '12')
                ->getQuery();
            $dec = sizeof($query12->getResult());

            $col = new ColumnChart();
            $col->getData()->setArrayToDataTable(
            [
                ['Mois', 'Nombre de contrats', ['role' => 'annotation']],
                ['Jan',  $jan, $jan],
                ['Fév',  $fev, $fev],
                ['Mar', $mar, $mar],
                ['Avr', $avr, $avr],
                ['Mai', $mai, $mai],
                ['Juin',  $juin, $juin],
                ['Juillet',  $juillet, $juillet],
                ['Août',  $aout, $aout],
                ['Sep',  $sep, $sep],
                ['Oct', $oct, $oct],
                ['Nov', $nov, $nov],
                ['Déc', $dec, $dec]
            ]
            );
            $col->getOptions()->setTitle('Nombre de contrats par mois en '.$year);
            $col->getOptions()->getAnnotations()->setAlwaysOutside(true);
            $col->getOptions()->getAnnotations()->getTextStyle()->setFontSize(14);
            $col->getOptions()->getAnnotations()->getTextStyle()->setColor('#000');
            $col->getOptions()->getAnnotations()->getTextStyle()->setAuraColor('none');
            $col->getOptions()->getHAxis()->setTitle('Mois');
            $col->getOptions()->getHAxis()->setFormat('h:mm a');
            $col->getOptions()->getHAxis()->getViewWindow()->setMin([7, 30, 0]);
            $col->getOptions()->getHAxis()->getViewWindow()->setMax([17, 30, 0]);
            $col->getOptions()->getVAxis()->setTitle('Nombre de contrats');
            $col->getOptions()->setWidth(900);
            $col->getOptions()->setHeight(500);
        }

    return $this->render('default/chart.html.twig', array('piechart' => $col, 'form' => $form->createView(),));
}


   public function rapportAction(Request $request, $id)
    {

        $this->get('logger')->debug('////////////////////////////////////////: ' . $id);

        $defaultData = ['message' => 'Type your message here'];

        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class, [
            'input' => 'datetime',
            'attr' => ['class' => 'calendar']
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
        ->setAction($this->generateUrl('rapport', ['id' => $id]))
        ->getForm();

        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository('LocationBundle:Voiture')->findOneById($id);
            
        $form->get('voiture')->setData($vehicule);

            $annee = date('Y');
            $mois = date('m');
            $year = $request->get('form')['date']['year'];
            $month = $request->get('form')['date']['month'];
            $time = $year.'-'.$month.'-'.'1';

            if($time == '--1'){
                $date= new \DateTime($annee);
                $date->setTime(0, 0);
                $form->get('date')->setData($date);
                $em = $this->getDoctrine()->getManager();
                $repository1 = $this->getDoctrine()->getRepository(Paiement::class);
                $query1= $repository1->createQueryBuilder('c')
                    ->join('c.refCsr', 'p')
                    ->join('p.refVoiture', 'v')
                    ->select('SUM(c.montantPaye)')
                    ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query1->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }    
                $montantEncaisse = $query1->getQuery()->getResult();
                if($montantEncaisse[0][1] == null){$montantEncaisse[0][1] = 0;};

                $query11= $repository1->createQueryBuilder('c')
                    ->join('c.refCsr', 'p')
                    ->join('p.refVoiture', 'v')
                    ->select('SUM(c.montantRestant)')
                    ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query11->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }    
                $credit = $query11->getQuery()->getResult();
                if($credit[0][1] == null){$credit[0][1] = 0;};

                $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
                $query2= $repository2->createQueryBuilder('c')
                    ->select('SUM(c.montantMensuel)')
                    ->where('((YEAR(c.datePremierPay) <= :annee AND MONTH(c.datePremierPay) <= :mois) OR (YEAR(c.datePremierPay) < :annee)) AND ((YEAR(c.dateDernierPay) >= :annee AND MONTH(c.dateDernierPay) >= :mois) OR (YEAR(c.dateDernierPay) > :annee))')
                    ->andwhere('c.disponibilite = true')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query2->andWhere('c.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $montantAEncaisse = $query2->getQuery()->getResult();
                if($montantAEncaisse[0][1] == null){$montantAEncaisse[0][1] = 0;};

                $query22= $repository2->createQueryBuilder('c')
                    ->select('c')
                    ->where('((YEAR(c.datePremierPay) <= :annee AND MONTH(c.datePremierPay) <= :mois) OR (YEAR(c.datePremierPay) < :annee)) AND ((YEAR(c.dateDernierPay) >= :annee AND MONTH(c.dateDernierPay) >= :mois) OR (YEAR(c.dateDernierPay) > :annee))')
                    ->andwhere('c.disponibilite = true')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query22->andWhere('c.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $nbreVoitures = sizeof($query22->getQuery()->getResult());

                $montantNonEncaisse = $montantAEncaisse[0][1]-$montantEncaisse[0][1];
                
                $query3= $repository1->createQueryBuilder('c')
                    ->join('c.refCsr', 'p')
                    ->join('p.refVoiture', 'v')
                    ->select('c')
                    ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois AND c.montantRestant <> 0')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query3->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $clientNonRegle = $query3->getQuery()->getResult();

                $repository5 = $this->getDoctrine()->getRepository(Visite::class);
                $query5= $repository5->createQueryBuilder('c')
                    ->join('c.refVoiture', 'v')
                    ->select('SUM(c.montant)')
                    ->where('YEAR(c.dateVisite) = :annee AND MONTH(c.dateVisite) = :mois')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query5->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $visites = $query5->getQuery()->getResult();

                $repository6 = $this->getDoctrine()->getRepository(Vidange::class);
                $query6= $repository6->createQueryBuilder('c')
                    ->join('c.refVoiture', 'v')
                    ->select('SUM(c.montant)')
                    ->where('YEAR(c.dateVidange) = :annee AND MONTH(c.dateVidange) = :mois')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query6->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $vidanges = $query6->getQuery()->getResult();

                $repository7 = $this->getDoctrine()->getRepository(Depenses::class);
                $query7= $repository7->createQueryBuilder('c')
                    ->join('c.refVoiture', 'v')
                    ->select('SUM(c.montant)')
                    ->where('YEAR(c.dateDepense) = :annee AND MONTH(c.dateDepense) = :mois')
                    ->setParameter('annee', $annee)
                    ->setParameter('mois', $mois);
                if ($id != 0) {
                    $query7->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $depenses = $query7->getQuery()->getResult();

                if($visites == null){$vistes = 0;};
                if($vidanges == null){$vidanges = 0;};
                if($depenses == null){$depenses = 0;};
                $frais = $visites[0][1]+$vidanges[0][1]+$depenses[0][1];

                $rapportMonth = $mois;
                $rapportYear = $annee;
            }
            else{
                $date= new \DateTime($time);
                $date->setTime(0, 0);
                $form->get('date')->setData($date);

                $em = $this->getDoctrine()->getManager();
                $repository1 = $this->getDoctrine()->getRepository(Paiement::class);
                
                $query1= $repository1->createQueryBuilder('c')
                    ->join('c.refCsr', 'p')
                    ->join('p.refVoiture', 'v')
                    ->select('SUM(c.montantPaye)')
                    ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);

                if ($id != 0) {
                    $query1->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }    

                $montantEncaisse = $query1->getQuery()->getResult();

                // $this->get('logger')->debug('//////////////////$montantEncaisse');
                // $this->get('logger')->debug(json_encode($montantEncaisse));
                // $this->get('logger')->debug('//////////////////$montantEncaisse');

                if($montantEncaisse[0][1] == null){$montantEncaisse[0][1] = 0;};

                $query11= $repository1->createQueryBuilder('c')
                    ->join('c.refCsr', 'p')
                    ->join('p.refVoiture', 'v')
                    ->select('SUM(c.montantRestant)')
                    ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);

                if ($id != 0) {
                    $query11->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }   
                $credit = $query11->getQuery()->getResult();
                if($credit[0][1] == null){$credit[0][1] = 0;};

                $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
                $query2= $repository2->createQueryBuilder('c')
                    ->select('SUM(c.montantMensuel)')
                    ->where('((YEAR(c.datePremierPay) <= :annee AND MONTH(c.datePremierPay) <= :mois) OR (YEAR(c.datePremierPay) < :annee)) AND ((YEAR(c.dateDernierPay) >= :annee AND MONTH(c.dateDernierPay) >= :mois) OR (YEAR(c.dateDernierPay) > :annee))')
                    ->andwhere('c.disponibilite = true')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);

                if ($id != 0) {
                    $query2->andWhere('c.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }  
                $montantAEncaisse = $query2->getQuery()->getResult();
                if($montantAEncaisse[0][1] == null){$montantAEncaisse[0][1] = 0;};

                $query22= $repository2->createQueryBuilder('c')
                    ->select('c')
                    ->where('((YEAR(c.datePremierPay) <= :annee AND MONTH(c.datePremierPay) <= :mois) OR (YEAR(c.datePremierPay) < :annee)) AND ((YEAR(c.dateDernierPay) >= :annee AND MONTH(c.dateDernierPay) >= :mois) OR (YEAR(c.dateDernierPay) > :annee))')
                    ->andwhere('c.disponibilite = true')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);

                if ($id != 0) {
                    $query22->andWhere('c.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $nbreVoitures = sizeof($query22->getQuery()->getResult());

                $montantNonEncaisse = $montantAEncaisse[0][1]-$montantEncaisse[0][1];
                
                $query3= $repository1->createQueryBuilder('c')
                    ->join('c.refCsr', 'p')
                    ->join('p.refVoiture', 'v')
                    ->select('c')
                    ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois AND c.montantRestant <> 0')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);

                if ($id != 0) {
                    $query3->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }

                $clientNonRegle = $query3->getQuery()->getResult();

                $repository5 = $this->getDoctrine()->getRepository(Visite::class);
                $query5= $repository5->createQueryBuilder('c')
                    ->join('c.refVoiture', 'v')
                    ->select('SUM(c.montant)')
                    ->where('YEAR(c.dateVisite) = :annee AND MONTH(c.dateVisite) = :mois')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);
                if ($id != 0) {
                    $query5->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $visites = $query5->getQuery()->getResult();

                $repository6 = $this->getDoctrine()->getRepository(Vidange::class);
                $query6= $repository6->createQueryBuilder('c')
                    ->join('c.refVoiture', 'v')
                    ->select('SUM(c.montant)')
                    ->where('YEAR(c.dateVidange) = :annee AND MONTH(c.dateVidange) = :mois')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);
                if ($id != 0) {
                    $query6->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $vidanges = $query6->getQuery()->getResult();

                $repository7 = $this->getDoctrine()->getRepository(Depenses::class);
                $query7= $repository7->createQueryBuilder('c')
                    ->join('c.refVoiture', 'v')
                    ->select('SUM(c.montant)')
                    ->where('YEAR(c.dateDepense) = :annee AND MONTH(c.dateDepense) = :mois')
                    ->setParameter('annee', $year)
                    ->setParameter('mois', $month);
                if ($id != 0) {
                    $query7->andWhere('v.id = :voitureId')
                        ->setParameter('voitureId', $id);
                }
                $depenses = $query7->getQuery()->getResult();

                if($visites == null){$vistes = 0;};
                if($vidanges == null){$vidanges = 0;};
                if($depenses == null){$depenses = 0;};
                $frais = $visites[0][1]+$vidanges[0][1]+$depenses[0][1];

                $rapportMonth = $month;
                $rapportYear = $year;
            }

        return $this->render('default/rapport.html.twig', array('form' => $form->createView(), 'rapportMonth' => $rapportMonth, 'rapportYear' => $rapportYear,
            'montantEncaisse' => $montantEncaisse[0][1],
            'montantAEncaisse' => $montantAEncaisse[0][1],
            'montantNonEncaisse' => $montantNonEncaisse,
            'frais'=> $frais,
            'clientNonRegle' => $clientNonRegle,
            'nbreVoitures' => $nbreVoitures,
            'credit' => $credit[0][1],
            'id' => $id,
            ));
    }

   public function reportByDateRangeAction(Request $request, $id)
    {

        // $this->get('logger')->debug('////////////////////////////////////////: ' . $id);
        // var_dump($id);

        $defaultData = ['message' => 'Type your message here'];

        $form = $this->createFormBuilder($defaultData)
        ->add('dateStart', DateType::class, [
            'input' => 'datetime',
            'widget' => 'single_text',
            'attr' => ['class' => 'calendar']
        ])
        ->add('dateEnd', DateType::class, [
            'input' => 'datetime',
            'widget' => 'single_text',
            'attr' => ['class' => 'calendar']
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
        ->setAction($this->generateUrl('rapportParPeriode', ['id' => $id]))
        ->getForm();

        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository('LocationBundle:Voiture')->findOneById($id);
            
        $form->get('voiture')->setData($vehicule);

        $dateStart = $request->get('form')['dateStart'];
        $dateEnd = $request->get('form')['dateEnd'];
 
        $date = new \DateTime();
        if (empty($dateStart) || empty($dateEnd)) {
            $dateStart = $date->setTime(0, 0, 0);
            $dateEnd   = $date->setTime(23, 59, 59);
        } else {
            $dateStart = (new \DateTime($dateStart))->setTime(0, 0, 0);
            $dateEnd   = (new \DateTime($dateEnd))->setTime(23, 59, 59);
        }

        $form->get('dateStart')->setData($dateStart);
        $form->get('dateEnd')->setData($dateEnd);

        $em = $this->getDoctrine()->getManager();
       
        $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
        
        $query22= $repository2->createQueryBuilder('c')
            ->join('c.marque', 'p')
            ->join('c.modele', 'v')
            ->select('c.id AS id, c.matricule AS matricule, p.nom AS marque, v.nom AS modele ')
            ->where('c.disponibilite = true');
            
        if ($id != 0) {
            $query22->andWhere('c.id = :voitureId')
                ->setParameter('voitureId', $id);
        }

        $voitures = $query22->getQuery()->getArrayResult();
        
        $repository1 = $this->getDoctrine()->getRepository(Paiement::class);
       
        $query1 = $repository1->createQueryBuilder('c')
            ->join('c.refCsr', 'p')
            ->join('p.refVoiture', 'v')
            ->select('v.id AS voitureId, SUM(c.montantPaye) AS totalPaye')
            ->andWhere('c.datePayement BETWEEN :dateStart AND :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->groupBy('v.id');

        if ($id != 0) {
            $query1->andWhere('v.id = :voitureId')
                ->setParameter('voitureId', $id);
        }

        $resultsMontantEncaisse = $query1->getQuery()->getArrayResult();

        // Transformer $resultsMontantAEncaisse en tableau associatif indexé par voitureId
        $montantEncaisseByVoiture = [];
        foreach ($resultsMontantEncaisse as $row) {
            $montantEncaisseByVoiture[$row['voitureId']] = $row['totalPaye'];
        }

        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voitureId = $voiture['id'];
            if (isset($montantEncaisseByVoiture[$voitureId])) {
                $voiture['montantEncaisse'] = $montantEncaisseByVoiture[$voitureId];
            } else {
                $voiture['montantEncaisse'] = 0; // si pas trouvé dans results
            }
        }
        unset($voiture); // bonne 
        
        // var_dump(json_encode($resultsMontantEncaisse));
       $query11 = $repository1->createQueryBuilder('c')
            ->join('c.refCsr', 'p')
            ->join('p.refVoiture', 'v')
            ->select('v.id AS voitureId, SUM(c.montantRestant) AS totalMontantRestant')
            ->andWhere('c.datePayement BETWEEN :dateStart AND :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->groupBy('v.id');

        if ($id != 0) {
            $query11->andWhere('v.id = :voitureId')
                ->setParameter('voitureId', $id);
        }
 
        $resultsCredit = $query11->getQuery()->getArrayResult();
 
        // var_dump(json_encode($resultsCredit));
       
        // Transformer $resultsMontantAEncaisse en tableau associatif indexé par voitureId
        $creditByVoiture = [];
        foreach ($resultsCredit as $row) {
            $creditByVoiture[$row['voitureId']] = $row['totalMontantRestant'];
        }
        //var_dump($resultsCredit);
        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voitureId = $voiture['id'];
            if (isset($creditByVoiture[$voitureId])) {
                $voiture['credit'] = $creditByVoiture[$voitureId];
            } else {
                $voiture['credit'] = 0; // si pas trouvé dans results
            }
        }
        unset($voiture); // bonne 

        $query2 = $repository2->createQueryBuilder('c')
            ->select('c.id AS voitureId, c.montantMensuel AS montantMensuel, c.datePremierPay AS datePremierPay, c.dateDernierPay AS dateDernierPay')
            ->andWhere('
                (c.datePremierPay >= :dateStart AND c.dateDernierPay <= :dateEnd)
                OR
                (c.datePremierPay <= :dateEnd AND c.dateDernierPay >= :dateStart)
                OR
                (c.datePremierPay BETWEEN :dateStart AND :dateEnd)
                OR
                (c.dateDernierPay BETWEEN :dateStart AND :dateEnd)
            ')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd);

        if ($id != 0) {
            $query11->andWhere('c.id = :voitureId')
                ->setParameter('voitureId', $id);
        }

        $resultsMontantAEncaisse = $query2->getQuery()->getArrayResult();
        
        // Transformer $resultsMontantAEncaisse en tableau associatif indexé par voitureId
        $montantAEncaisseByVoiture = [];
        foreach ($resultsMontantAEncaisse as $row) {
            $voitureId = $row['voitureId'];
            $montantMensuel = $row['montantMensuel'];

            $datePremierPay = clone $row['datePremierPay'];  // safe
            $dateDernierPay = clone $row['dateDernierPay'];  // safe

            // borne réelle = intersection
            $start = max($dateStart, $datePremierPay);
            $end   = min($dateEnd, $dateDernierPay);

            $count = 0;
            if ($start <= $end) {
                // Jour de paiement fixé par datePremierPay
                $dayPayment = (int)$datePremierPay->format('d');

                // premier paiement >= start
                $current = (clone $datePremierPay);
                if ($current < $start) {
                    // avancer au mois du start
                    $current = clone $start;
                    
                    $current->setDate(
                        $start->format('Y'),
                        $start->format('m'),
                        min($dayPayment, cal_days_in_month(CAL_GREGORIAN, $start->format('m'), $start->format('Y')))
                    );
                    if ($current < $start) {
                        $current->modify('+1 month');
                    }
                }

                // parcourir jusqu’à end
                while ($current <= $end && $current <= $dateDernierPay) {
                    $count++;
                    $current->modify('+1 month');
                }
            }

            $montantAEncaisseByVoiture[$voitureId] = $count * $montantMensuel;
        }


        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voitureId = $voiture['id'];
            if (isset($montantAEncaisseByVoiture[$voitureId])) {
                $voiture['montantAEncaisse'] = $montantAEncaisseByVoiture[$voitureId];
            } else {
                $voiture['montantAEncaisse'] = 0; // si pas trouvé dans results
            }
        }
        unset($voiture); // bonne 

        $query22= $repository2->createQueryBuilder('c')
            ->select('c')
            ->where('
                ((c.datePremierPay BETWEEN :dateStart AND :dateEnd) OR (:dateStart > c.datePremierPay))
                And ((c.dateDernierPay BETWEEN :dateStart AND :dateEnd) OR (:dateEnd < c.dateDernierPay))
            ')
            ->andwhere('c.disponibilite = true')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd);
            
        if ($id != 0) {
            $query22->andWhere('c.id = :voitureId')
                ->setParameter('voitureId', $id);
        }
        $nbreVoitures = sizeof($query22->getQuery()->getArrayResult());
        
        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voiture['montantNonEncaisse'] = $voiture['montantAEncaisse'] - $voiture['montantEncaisse'];
        }
        unset($voiture); // bonne

        $query3= $repository1->createQueryBuilder('c')
            ->join('c.refCsr', 'p')
            ->join('p.refVoiture', 'v')
            ->select('c')
            ->where('c.datePayement BETWEEN :dateStart AND :dateEnd AND c.montantRestant <> 0')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd);

        if ($id != 0) {
            $query3->andWhere('v.id = :voitureId')
                ->setParameter('voitureId', $id);
        }

        $clientNonRegle = $query3->getQuery()->getResult();

        $repository5 = $this->getDoctrine()->getRepository(Visite::class);

        $query5= $repository5->createQueryBuilder('c')
            ->join('c.refVoiture', 'v')
            ->select('v.id AS voitureId, SUM(c.montant) AS totalMontant')
            ->where('c.dateVisite BETWEEN :dateStart AND :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->groupBy('v.id');
        if ($id != 0) {
            $query5->andWhere('v.id = :voitureId')
                ->setParameter('voitureId', $id);
        }
        $resultsVisites = $query5->getQuery()->getArrayResult();

        // Transformer $resultsMontantAEncaisse en tableau associatif indexé par voitureId
        $visitesByVoiture = [];
        foreach ($resultsVisites as $row) {
            $visitesByVoiture[$row['voitureId']] = $row['totalMontant'];
        }

        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voitureId = $voiture['id'];
            if (isset($visitesByVoiture[$voitureId])) {
                $voiture['visites'] = $visitesByVoiture[$voitureId];
            } else {
                $voiture['visites'] = 0; // si pas trouvé dans results
            }
        }
        unset($voiture); // bonne 

        $repository6 = $this->getDoctrine()->getRepository(Vidange::class);

        $query6= $repository6->createQueryBuilder('c')
            ->join('c.refVoiture', 'v')
            ->select('v.id AS voitureId, SUM(c.montant) AS totalMontant')
            ->where('c.dateVidange BETWEEN :dateStart AND :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->groupBy('v.id');
        if ($id != 0) {
            $query6->andWhere('v.id = :voitureId')
                ->setParameter('voitureId', $id);
        }
        $resultsVidanges = $query6->getQuery()->getArrayResult();
        
        // Transformer $resultsMontantAEncaisse en tableau associatif indexé par voitureId
        $vidangesByVoiture = [];
        foreach ($resultsVisites as $row) {
            $vidangesByVoiture[$row['voitureId']] = $row['totalMontant'];
        }

        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voitureId = $voiture['id'];
            if (isset($vidangesByVoiture[$voitureId])) {
                $voiture['vidanges'] = $vidangesByVoiture[$voitureId];
            } else {
                $voiture['vidanges'] = 0; // si pas trouvé dans results
            }
        }
        unset($voiture); // bonne 

        $repository7 = $this->getDoctrine()->getRepository(Depenses::class);

        $query7= $repository7->createQueryBuilder('c')
            ->join('c.refVoiture', 'v')
            ->select('v.id AS voitureId, SUM(c.montant) AS totalMontant')
            ->where('c.dateDepense BETWEEN :dateStart AND :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->groupBy('v.id');
        if ($id != 0) {
            $query7->andWhere('v.id = :voitureId')
                ->setParameter('voitureId', $id);
        }
        $resultsDepenses = $query7->getQuery()->getArrayResult();

        // Transformer $resultsMontantAEncaisse en tableau associatif indexé par voitureId
        $depensesByVoiture = [];
        foreach ($resultsDepenses as $row) {
            $depensesByVoiture[$row['voitureId']] = $row['totalMontant'];
        }

        // Fusionner avec la liste des voitures
        foreach ($voitures as &$voiture) {
            $voitureId = $voiture['id'];
            if (isset($depensesByVoiture[$voitureId])) {
                $voiture['depenses'] = $depensesByVoiture[$voitureId];
            } else {
                $voiture['depenses'] = 0; // si pas trouvé dans results
            }
        }
        unset($voiture); // bonne 

        // Fusionner avec la liste des voitures
        $resultsOfPeriod = 0;
        foreach ($voitures as &$voiture) {
           $voiture['frais'] = $voiture['visites'] + $voiture['vidanges'] + $voiture['depenses'];
           $resultsOfPeriod += ($voiture['montantEncaisse'] - $voiture['frais'] - $voiture['montantAEncaisse']);
        }

        return $this->render('default/reportByDateRange.html.twig', array('form' => $form->createView(), 
            'clientNonRegle' => $clientNonRegle,
            'nbreVoitures' => $nbreVoitures,
            'voitures' => $voitures,
            'resultsOfPeriod' => $resultsOfPeriod,
            'id' => $id,
            ));
    }

    public function creditAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class); 
        $query= $repository->createQueryBuilder('c')
            ->select('c')
            ->where('c.montantRestant <> 0')
            ->getQuery();
        $clientNonRegle = $query->getResult();

        return $this->render('default/credit.html.twig', array('clientNonRegle' => $clientNonRegle,
            ));
    }

public function print2Action(Request $request) {
    
    $repository = $this->getDoctrine()->getRepository(Paiement::class);
    $query= $repository->createQueryBuilder('c')
                ->select('c')
                ->where('YEAR(c.datePayement) = :annee AND MONTH(c.datePayement) = :mois AND c.montantRestant <> 0')
                ->setParameter('annee', $_GET['rapportYear'])
                ->setParameter('mois', $_GET['rapportMonth'])
                ->getQuery();
    $clientNonRegle = $query->getResult();
    // On récupère l'objet à afficher (rien d'inconnu jusque là) 
    // On crée une  instance pour définir les options de notre fichier pdf
    $options = new Options();
    // Pour simplifier l'affichage des images, on autorise dompdf à utiliser 
    // des  url pour les nom de  fichier
    // On crée une instance de dompdf avec  les options définies
    $dompdf = new Dompdf($options);
    // On demande à Symfony de générer  le code html  correspondant à 
    // notre template, et on stocke ce code dans une variable
    $options->set('isRemoteEnabled', TRUE);
    $html = $this->renderView(
      'default/print.html.twig', 
      array(
        'rapportMonth' => $_GET['rapportMonth'],
        'rapportYear' => $_GET['rapportYear'],
        'montantEncaisse' => $_GET['montantEncaisse'],
        'montantAEncaisse' => $_GET['montantAEncaisse'],
        'frais'=> $_GET['frais'],
        'clientNonRegle' => $clientNonRegle,
        'nbreVoitures' => $_GET['nbreVoitures'],
        'credit' => $_GET['credit'],)
    );
    // On envoie le code html  à notre instance de dompdf
    $dompdf->loadHtml($html);        
    // On demande à dompdf de générer le  pdf
    $dompdf->render();
    // On renvoie  le flux du fichier pdf dans une  Response pour l'utilisateur
    return new Response ($dompdf->stream("rapport.pdf", array("Attachment" => false)));
}

    public function indexAction()
    {
         $em = $this->getDoctrine()->getManager();

        $agences = $em->getRepository('LocationBundle:Agence')->findAll();

        $mois = date("m");
        $annee = date("Y");
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(CSR::class);
        $query= $repository->createQueryBuilder('c')
            ->select('c')
            ->where('MONTH(c.dateContrat) = :mois and YEAR(c.dateContrat) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->getQuery();
        $contrats = sizeof($query->getResult());

        $query0= $repository->createQueryBuilder('c')
            ->select('c')
            ->where('c.dateDebut <= NOW() and c.dateFin >= NOW()')
            ->getQuery();
        $contratsEncours = $query0->getResult();

        $em = $this->getDoctrine()->getManager();
        $repository1 = $this->getDoctrine()->getRepository(CSR::class);
        $query1= $repository->createQueryBuilder('c')
            ->select('c')
            ->where('MONTH(c.dateContrat) = :mois and YEAR(c.dateContrat) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->getQuery();
        $contrats = sizeof($query1->getResult());
        
        $repository2 = $this->getDoctrine()->getRepository(Voiture::class);
        $query2= $repository2->createQueryBuilder('c')
            ->select('c')
            ->where('c.etat = :etat and c.disponibilite = true and c.isEnable = true')
            ->setParameter('etat', 'Location')
            ->getQuery();
        $allVoitures = $query2->getResult();
        
        $voituresl = sizeof($allVoitures);
        
        $clients = sizeof($em->getRepository('LocationBundle:Client')->findByDisponibilite(true));

        $repository3 = $this->getDoctrine()->getRepository(Paiement::class);
        $query3= $repository3->createQueryBuilder('p')
            ->select('p')
            ->where('MONTH(p.datePayement) = :mois and YEAR(p.datePayement) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->getQuery();
        $paiements = $query3->getResult();

        $query4= $repository3->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('MONTH(p.datePayement) = :mois and YEAR(p.datePayement) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->getQuery();
        $sommeJournee = $query4->getResult();

        $repository4 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        $query5= $repository4->createQueryBuilder('ps')
            ->select('ps')
            ->where('MONTH(ps.date) = :mois and YEAR(ps.date) = :annee')
            ->setParameter('mois', $mois)
             ->setParameter('annee', $annee)
            ->getQuery();
        $paiementSoustraitances = $query5->getResult();

        $query6= $repository4->createQueryBuilder('ps')
            ->select('SUM(ps.montant)')
            ->where('MONTH(ps.date) = :mois and YEAR(ps.date) = :annee')
            ->setParameter('mois', $mois)
             ->setParameter('annee', $annee)
            ->getQuery();
        $sommeJournee2 = $query6->getResult();

        $date = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00',strtotime('+1 day'));
        $now = new \DateTime($date);
        $now2 = new\DateTime($date2);

        $date = $now->format('Y-m-d H:i');
        $date = str_replace (' ', 'T', $date);
        $date2 = $now2->format('Y-m-d H:i');
        $date2 = str_replace (' ', 'T', $date2);
        $duree =  '1 jours ,0 heures ,0 minutes';

        $repository5 = $this->getDoctrine()->getRepository(Disponibilite::class);

         $query7 = $repository5->createQueryBuilder('d2')
        ->where('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin >= :date2')
        ->orwhere('d2.dateDebut <= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->orwhere('d2.dateDebut >= :date1 and d2.dateDebut <= :date2 and d2.dateFin >= :date1 and d2.dateFin <= :date2')
        ->setParameter('date1', $now)
        ->setParameter('date2', $now2)
        ->orderBy('d2.dateDebut', 'ASC')
        ->getQuery();
        $disponibilites2 = $query7->getResult();

       $repository6 = $this->getDoctrine()->getRepository(Voiture::class);
       $query8 = $repository2->createQueryBuilder('v')
        ->select()
        ->getQuery();
       $voitures = $query8->getResult();
       $disponibilites3 = array();

       if ($voitures == null){

       }
       else
       {
            for ($i = 0; $i < sizeof($voitures); $i++) {
                $dispo = true;
                for ($j = 0; $j < sizeof($disponibilites2); $j++){
                
                    if ($voitures[$i]->getMatricule() == $disponibilites2[$j]->getRefVoiture()->getMatricule())
                    {
                        $dispo = false;
                        $j=sizeof($disponibilites2);
                    }
                
                }
                if ($dispo == true and $voitures[$i]->getDisponibilite() == true and $voitures[$i]->getIsEnable() == true )
                {
                    $disponibilites3[]= $voitures[$i];
                }
            
            };
        }

         $repovisite = $this->getDoctrine()->getRepository(Visite::class);
         $queryvisite = $repovisite->createQueryBuilder('v')
        //->where('v.dateProchVisite >= :now ')
        //->setParameter('now', new \DateTime('now'))
        ->orderBy('v.dateProchVisite', 'DESC')
        //->setMaxResults(1)
        ->getQuery();
        $vis = $queryvisite->getResult();
        
        $repovidange = $this->getDoctrine()->getRepository(Vidange::class);
         $queryvidange = $repovidange->createQueryBuilder('vid')
        //->where('vid.dateVidange >= :now ')
        //->setParameter('now',date('Y-m-d'))
        //->orderBy('vid.dateVidange', 'DESC')
        ->orderBy('vid.refVoiture', 'DESC')
        //->setMaxResults(1)
        ->getQuery();
        $vid = $queryvidange->getResult();
        
        $reporetour = $this->getDoctrine()->getRepository(Retour::class);
         $queryretour = $reporetour->createQueryBuilder('ret')
        //->where('ret.dateVidange >= :now ')
        //->setParameter('now', new \DateTime('now'))
        ->orderBy('ret.id', 'DESC')
        //->setMaxResults(1)
        ->getQuery();
        $ret = $queryretour->getResult();

        $repoass = $this->getDoctrine()->getRepository(Assurance::class);
         $queryass = $repoass->createQueryBuilder('ass')
        //->where('ret.dateProchAssurance >= :now ')
        //->setParameter('now', new \DateTime('now'))
        ->orderBy('ass.id', 'DESC')
        //->setMaxResults(1)
        ->getQuery();
        $ass = $queryass->getResult();

        $allVidanges = $em->getRepository('LocationBundle:Vidange')->findAll();
       
        $voituresWithLastVidange = [];

        foreach ($allVoitures as $voiture) {
            $voitureId = $voiture->getId();
            $lastVidange = null;

            foreach ($allVidanges as $vidange) {
                // Vérifie que la vidange appartient à cette voiture
                if ($vidange->getRefVoiture()->getId() === $voitureId) {
                    // Si c'est la première vidange trouvée OU si prochVidange est plus grand
                    if ($lastVidange === null || $vidange->getProchVidange() > $lastVidange->getProchVidange()) {
                        $lastVidange = $vidange;
                    }
                }
            }

            $voituresWithLastVidange[] = [
                'matricule' => $voiture->getMatricule(),
                'modele' => $voiture->getModele(),
                'marque' => $voiture->getMarque(),
                'voiture' => $voiture,
                'last_vidange' => $lastVidange,
            ];
        }
        // last vidange par rapport number of prochVidange each ref_voiture_id

        $allVisites = $em->getRepository('LocationBundle:Visite')->findAll();
       
        $voituresWithLastVisite = [];

        foreach ($allVoitures as $voiture) {
            $voitureId = $voiture->getId();
            $lastVisite = null;

            foreach ($allVisites as $Visite) {
                // Vérifie que la Visite appartient à cette voiture
                if ($Visite->getRefVoiture()->getId() === $voitureId) {
                    // Si c'est la première Visite trouvée OU si prochVisite est plus grand
                    if ($lastVisite === null || $Visite->getDateProchVisite() > $lastVisite->getDateProchVisite()) {
                        $lastVisite = $Visite;
                    }
                }
            }

            $voituresWithLastVisite[] = [
                'voiture' => $voiture,
                'last_Visite' => $lastVisite,
            ];
        }

        //dump($voituresWithLastVisite);
        // dump(array(
        //     'visites' => $vis,
        //     'vidanges' => $vid,
        //     'retours' => $ret,
        //     'assurances' => $ass,
        //     'agences' => $agences,
        //     'contrats' => $contrats,
        //     'voituresl' => $voituresl,
        //     'disponibilites3' => $disponibilites3,
        //     'clients' => $clients,
        //     'mp'=>$sommeJournee[0][1]+$sommeJournee2[0][1],
        //     'mr'=>$sommeJournee[0][2],
        //     'time1' => $date,
        //     'time2'=> $date2,
        //     'duree' => $duree,
        //     'contratsEncours' => $contratsEncours,
        //     'voituresWithLastVidange' => $voituresWithLastVidange,
        //     'voituresWithLastVisite' => $voituresWithLastVisite
        // ));

        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('LocationBundle:Reservation')->findAll();
        $csrs = $em->getRepository('LocationBundle:Csr')->findAll();
        $paiements = $em->getRepository('LocationBundle:Paiement')->findAll();

        $newReservations = [];
        $dateNow = new \DateTime();
        foreach ($reservations as $reservation) {
            // 🔁 Ignorer les réservations futures
            if ($reservation->getDateDebut() < $dateNow) {
                continue;
            }
        
            // 🔎 Trouver le CSR lié
            $matchedCsr = null;
            foreach ($csrs as $csr) {
                if ($csr->getRefReservation() && $csr->getRefReservation()->getId() === $reservation->getId()) {
                    $matchedCsr = $csr;
                    break;
                }
            }
        
            // 💰 Trouver le paiement lié
            $montantPaye = 0;
            if ($matchedCsr !== null) {
                foreach ($paiements as $paiement) {
                    if ($paiement->getRefCsr() && $paiement->getRefCsr()->getId() === $matchedCsr->getId()) {
                        $montantPaye = $paiement->getMontantPaye();
                        break;
                    }
                }
            }
        
            // 📦 Objets liés
            $voiture = $reservation->getRefVoiture();
            $client = $reservation->getRefClient();
        
            $newReservations[] = [
                'numReservation' => $reservation->getNumReservation(),
                'dateDebut' => $reservation->getDateDebut(),
                'dateFin' => $reservation->getDateFin(),
                'voiture' => $voiture->getMatricule() . " " . $voiture->getMarque() . " " . $voiture->getModele(),
                'client' => $client->getNom() . " " . $client->getPrenom(),
                'telephone' => $client->getTelephone(),
                'paiment' => $montantPaye,
            ];
        }

        //dump($newReservations);

        $today = new \DateTime();
        $voituresAvecPaiementImminent = [];
        foreach ($allVoitures as $voiture) {
            $datePremierPay = $voiture->getDatePremierPay();
            $dateDernierPay = $voiture->getDateDernierPay();
            $montantMensuel = $voiture->getMontantMensuel();
            $montantTotal = $voiture->getMontantTotal();

            if (!$datePremierPay || !$dateDernierPay) {
                continue;
            }

            // Calcul du nombre de paiements effectués jusqu’à aujourd’hui
            $interval = $datePremierPay->diff(min($today, $dateDernierPay));
            $nbMoisPayes = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0);
            $montantPayee = $nbMoisPayes * $montantMensuel;

            // Si aujourd’hui est après la dernière date, on considère que tout est payé
            if ($today > $dateDernierPay) {
                $montantPayee = $montantTotal;
            }

            // Calcul du montant du dernier mois
            $montantDernierMois = min($montantMensuel, max(0, $montantTotal - $montantPayee));


            if (!$datePremierPay || !$dateDernierPay) {
                continue;
            }
        
            $echeance = clone $datePremierPay;
        
            while ($echeance <= $dateDernierPay) {
                $diffJours = (int)$today->diff($echeance)->format('%r%a');
        
                if ($diffJours >= 0 && $diffJours <= 3) {
                    $voituresAvecPaiementImminent[] = [
                        'voiture' => $voiture,
                        'echeance' => $echeance->format('Y-m-d'),
                        'jours_restants' => $diffJours,
                        'montant' => $montantDernierMois,
                    ];
                    break; // on a trouvé une échéance proche, inutile de continuer
                }
        
                $echeance->modify('+1 month');
            }
        }

        return $this->render('@Location/Default/index.html.twig', array(
            'visites' => $vis,
            'vidanges' => $vid,
            'retours' => $ret,
            'assurances' => $ass,
            'agences' => $agences,
            'contrats' => $contrats,
            'voituresl' => $voituresl,
            'voitures' => $voitures,
            'disponibilites3' => $disponibilites3,
            'clients' => $clients,
            'mp'=>$sommeJournee[0][1]+$sommeJournee2[0][1],
            'mr'=>$sommeJournee[0][2],
            'time1' => $date,
            'time2'=> $date2,
            'duree' => $duree,
            'contratsEncours' => $contratsEncours,
            'voituresWithLastVidange' => $voituresWithLastVidange,
            'voituresWithLastVisite' => $voituresWithLastVisite,
            'reservations' => $newReservations,
            'voituresAvecPaiementImminent' => $voituresAvecPaiementImminent
        ));
    }

    public function recetteJourAction()
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('recette_jour1'))
        ->getForm();
        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime();
        $form->get('date')->setData($now);

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class);
        $query= $repository->createQueryBuilder('p')
            ->select('p')
            ->where('p.datePayement = CURRENT_DATE()')
            ->getQuery();
            $paiements = $query->getResult();
        
        $query2= $repository->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('p.datePayement = CURRENT_DATE()')
            ->getQuery();
            $sommeJournee = $query2->getResult();
        
        // $repository2 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        // $query3= $repository2->createQueryBuilder('ps')
        //     ->select('ps')
        //     ->where('ps.date = CURRENT_DATE()')
        //     ->getQuery();
        //     $paiementSoustraitances = $query3->getResult();

        // $query4= $repository2->createQueryBuilder('ps')
        //     ->select('SUM(ps.montant)')
        //     ->where('ps.date = CURRENT_DATE()')
        //     ->getQuery();
        //     $sommeJournee2 = $query4->getResult();
      


        return $this->render('recette/indexJour.html.twig', array(
            'form' => $form->createView(),
            'paiements' => $paiements,
            //'paiementSoustraitances' => $paiementSoustraitances,
            'mp'=>$sommeJournee[0][1],
            'mr'=>$sommeJournee[0][2],
        ));
    }

    public function recetteJour1Action(Request $request)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime','widget' => 'single_text', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('recette_jour1'))
        ->getForm();
        
        $time = $request->get('form')['date'];
        $date= new \DateTime($time);
        $form->get('date')->setData($date);

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class);
        $query= $repository->createQueryBuilder('p')
            ->select('p')
            ->where('p.datePayement = :date')
            ->setParameter('date', $date)
            ->getQuery();
            $paiements = $query->getResult();

        $query2= $repository->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('p.datePayement = :date')
            ->setParameter('date', $date)
            ->getQuery();
            $sommeJournee = $query2->getResult();

        // $repository2 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        // $query3= $repository2->createQueryBuilder('ps')
        //     ->select('ps')
        //     ->where('ps.date = :date')
        //     ->setParameter('date', $date)
        //     ->getQuery();
        //     $paiementSoustraitances = $query3->getResult();

        // $query4= $repository2->createQueryBuilder('ps')
        //     ->select('SUM(ps.montant)')
        //     ->where('ps.date = :date')
        //     ->setParameter('date', $date)
        //     ->getQuery();
        //     $sommeJournee2 = $query4->getResult();
            
        return $this->render('recette/indexJour1.html.twig', array(
            'time' => $time,
            'form' => $form->createView(),
            'paiements' => $paiements,
            //'paiementSoustraitances' => $paiementSoustraitances,
            'mp'=>$sommeJournee[0][1],
            'mr'=>$sommeJournee[0][2],
        ));
    }

    public function recetteMoisAction()
    {   
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('recette_mois1'))
        ->getForm();

        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime();
        $form->get('date')->setData($now);


        $mois = date("m");
        $annee = date("Y");
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class);
        $query= $repository->createQueryBuilder('p')
            ->select('p')
            ->where('MONTH(p.datePayement) = :mois and YEAR(p.datePayement) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->getQuery();
            $paiements = $query->getResult();

        $query2= $repository->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('MONTH(p.datePayement) = :mois and YEAR(p.datePayement) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->getQuery();
            $sommeJournee = $query2->getResult();

        // $repository2 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        // $query3= $repository2->createQueryBuilder('ps')
        //     ->select('ps')
        //     ->where('MONTH(ps.date) = :mois and YEAR(ps.date) = :annee')
        //     ->setParameter('mois', $mois)
        //      ->setParameter('annee', $annee)
        //     ->getQuery();
        //     $paiementSoustraitances = $query3->getResult();

        // $query4= $repository2->createQueryBuilder('ps')
        //     ->select('SUM(ps.montant)')
        //     ->where('MONTH(ps.date) = :mois and YEAR(ps.date) = :annee')
        //     ->setParameter('mois', $mois)
        //      ->setParameter('annee', $annee)
        //     ->getQuery();
        //     $sommeJournee2 = $query4->getResult();

        return $this->render('recette/indexMois.html.twig', array(
            'form' => $form->createView(),
            'paiements' => $paiements,
            //'paiementSoustraitances' => $paiementSoustraitances,
            'mp'=>$sommeJournee[0][1],
            'mr'=>$sommeJournee[0][2],
        ));
    }


    public function recetteMois1Action(Request $request)
    {   
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('recette_mois1'))
        ->getForm();
        
        $month = $request->get('form')['date']['month'];
        $year = $request->get('form')['date']['year'];
        $time = $year.'-'.$month.'-'.'1';
        //var_dump($time);
        $date= new \DateTime($time);
        $form->get('date')->setData($date);


        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class);
        $query= $repository->createQueryBuilder('p')
            ->select('p')
            ->where('MONTH(p.datePayement) = :mois AND YEAR(p.datePayement) = :annee')
            ->setParameter('mois', $month)
            ->setParameter('annee', $year)
            ->getQuery();
            $paiements = $query->getResult();

        $query2= $repository->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('MONTH(p.datePayement) = :mois AND YEAR(p.datePayement) = :annee')
            ->setParameter('mois', $month)
            ->setParameter('annee', $year)
            ->getQuery();
            $sommeJournee = $query2->getResult();

        // $repository2 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        // $query3= $repository2->createQueryBuilder('ps')
        //     ->select('ps')
        //     ->where('MONTH(ps.date) = :mois AND YEAR(ps.date) = :annee')
        //     ->setParameter('mois', $month)
        //     ->setParameter('annee', $year)
        //     ->getQuery();
        //     $paiementSoustraitances = $query3->getResult();

        // $query4= $repository2->createQueryBuilder('ps')
        //     ->select('SUM(ps.montant)')
        //     ->where('MONTH(ps.date) = :mois AND YEAR(ps.date) = :annee')
        //     ->setParameter('mois', $month)
        //     ->setParameter('annee', $year)
        //     ->getQuery();
        //     $sommeJournee2 = $query4->getResult();

        return $this->render('recette/indexMois1.html.twig', array(
            'form' => $form->createView(),
            'paiements' => $paiements,
            //'paiementSoustraitances' => $paiementSoustraitances,
            'mp'=>$sommeJournee[0][1],
            'mr'=>$sommeJournee[0][2],
            'month' => $month,
            'year' => $year,
        ));
    }

    public function recetteAnAction()
    {   
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('recette_an1'))
        ->getForm();

        $tz = new \DateTimeZone('Europe/London');
        $now = new \DateTime();
        $form->get('date')->setData($now);

        $annee = date("Y");
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class);
        $query= $repository->createQueryBuilder('p')
            ->select('p')
            ->where('YEAR(p.datePayement) = :annee')
            ->setParameter('annee', $annee)
            ->getQuery();
            $paiements = $query->getResult();

        $query2= $repository->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('YEAR(p.datePayement) = :annee')
            ->setParameter('annee', $annee)
            ->getQuery();
            $sommeJournee = $query2->getResult();

        // $repository2 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        // $query3= $repository2->createQueryBuilder('ps')
        //     ->select('ps')
        //     ->where('YEAR(ps.date) = :annee')
        //     ->setParameter('annee', $annee)
        //     ->getQuery();
        //     $paiementSoustraitances = $query3->getResult();

        // $query4= $repository2->createQueryBuilder('ps')
        //     ->select('SUM(ps.montant)')
        //     ->where('YEAR(ps.date) = :annee')
        //     ->setParameter('annee', $annee)
        //     ->getQuery();
        //     $sommeJournee2 = $query4->getResult();

        return $this->render('recette/indexAn.html.twig', array(
            'form' => $form->createView(),
            'paiements' => $paiements,
            //'paiementSoustraitances' => $paiementSoustraitances,
            'mp'=>$sommeJournee[0][1],
            'mr'=>$sommeJournee[0][2],
        ));
    }

    public function recetteAn1Action(Request $request)
    {   
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('date', DateType::class,array('input' => 'datetime', 'attr' => array('class' => 'calendar')))
        ->setAction($this->generateUrl('recette_an1'))
        ->getForm();
        
        $year = $request->get('form')['date']['year'];
        $time = $year.'-'.'1'.'-'.'1';
        $date= new \DateTime($time);
        //var_dump($time);
        $form->get('date')->setData($date);


        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Paiement::class);
        $query= $repository->createQueryBuilder('p')
            ->select('p')
            ->where('YEAR(p.datePayement) = :annee')
            ->setParameter('annee', $year)
            ->getQuery();
            $paiements = $query->getResult();

        $query2= $repository->createQueryBuilder('p')
            ->select('SUM(p.montantPaye), SUM(p.montantRestant)')
            ->where('YEAR(p.datePayement) = :annee')
            ->setParameter('annee', $year)
            ->getQuery();
            $sommeJournee = $query2->getResult();

        // $repository2 = $this->getDoctrine()->getRepository(PaiementSoustraitance::class);
        // $query3= $repository2->createQueryBuilder('ps')
        //     ->select('ps')
        //     ->where('YEAR(ps.date) = :annee')
        //     ->setParameter('annee', $year)
        //     ->getQuery();
        //     $paiementSoustraitances = $query3->getResult();

        // $query4= $repository2->createQueryBuilder('ps')
        //     ->select('SUM(ps.montant)')
        //     ->where('YEAR(ps.date) = :annee')
        //     ->setParameter('annee', $year)
        //     ->getQuery();
        //     $sommeJournee2 = $query4->getResult();

        return $this->render('recette/indexAn1.html.twig', array(
            'form' => $form->createView(),
            'paiements' => $paiements,
            //'paiementSoustraitances' => $paiementSoustraitances,
            'mp'=>$sommeJournee[0][1],
            'mr'=>$sommeJournee[0][2],
            'year' => $year,
        ));
    }
    
}
