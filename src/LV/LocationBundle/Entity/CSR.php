<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CSR
 *
 * @ORM\Table(name="c_s_r")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\CSRRepository")
 */
 /**
 * @ORM\Entity
 * @UniqueEntity("numContrat", message="Contrat déjà existant")
 */
class CSR
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @var string
     *
     * @ORM\Column(name="numContrat", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $numContrat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateContrat", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $dateContrat;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $dateDebut;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Expression(
     *     "this.getDateDebut() <= this.getDateFin()",
     *     message="Date départ doît être inférieur au date d'arrivée"
     * )
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $conducteur1;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $conducteur2;
    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Voiture")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refVoiture;

     /**
     * @var string
     *
     * @ORM\Column(name="nbreJour", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nbreJour;

    /**
     * @var float
     *
     * @ORM\Column(name="kmDepart", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $kmDepart;

    /**
     * @var float
     *
     * @ORM\Column(name="kmRetour", type="float", nullable=true)
     */
    private $kmRetour;

     /**
     * @var string
     *
     * @ORM\Column(name="niveauCarburant", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $niveauCarburant;

    /**
     * @var float
     *
     * @ORM\Column(name="tarif", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $tarif;

    /**
     * @var float
     *
     * @ORM\Column(name="garant", type="float", nullable=true)
     */
    private $garant;

    /**
     * @var float
     *
     * @ORM\Column(name="fraisAeroport", type="float", nullable=true)
     */
    private $fraisAeroport;

    /**
     * @var float
     *
     * @ORM\Column(name="siegeBebe", type="float", nullable=true)
     */
    private $siegeBebe;

    /**
     * @var float
     *
     * @ORM\Column(name="supplement", type="float", nullable=true)
     */
    private $supplement;

    /**
     * @var float
     *
     * @ORM\Column(name="carburant", type="float", nullable=true)
     */
    private $carburant;

    /**
     * @var float
     *
     * @ORM\Column(name="totalHTVA", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $totalHTVA;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $TVA;

    /**
     * @var float
     *
     * @ORM\Column(name="sousTotal", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $sousTotal;

    /**
     * @var float
     *
     * @ORM\Column(name="timbre", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $timbre;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $total;

    /**
     * @var float
     *
     * @ORM\Column(name="recette", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $recette;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="etatRetour", type="string", length=255, nullable=true)
     */
    private $etatRetour;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Reservation")
     * @ORM\JoinColumn(nullable=true ,onDelete="CASCADE")
     */
    private $refReservation;

    /**
     * @var bool
     *
     * @ORM\Column(name="degats", type="boolean", nullable=true)
     */
    private $degats;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numContrat
     *
     * @param string $numContrat
     *
     * @return CSR
     */
    public function setNumContrat($numContrat)
    {
        $this->numContrat = $numContrat;

        return $this;
    }

    /**
     * Get numContrat
     *
     * @return string
     */
    public function getNumContrat()
    {
        return $this->numContrat;
    }

    /**
     * Set dateContrat
     *
     * @param \DateTime $dateContrat
     *
     * @return CSR
     */
    public function setDateContrat($dateContrat)
    {
        $this->dateContrat = $dateContrat;

        return $this;
    }

    /**
     * Get dateContrat
     *
     * @return \DateTime
     */
    public function getDateContrat()
    {
        return $this->dateContrat;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return CSR
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return CSR
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set nbreJour
     *
     * @param string $nbreJour
     *
     * @return CSR
     */
    public function setNbreJour($nbreJour)
    {
        $this->nbreJour = $nbreJour;

        return $this;
    }

    /**
     * Get nbreJour
     *
     * @return string
     */
    public function getNbreJour()
    {
        return $this->nbreJour;
    }

    /**
     * Set kmDepart
     *
     * @param float $kmDepart
     *
     * @return CSR
     */
    public function setKmDepart($kmDepart)
    {
        $this->kmDepart = $kmDepart;

        return $this;
    }

    /**
     * Get kmDepart
     *
     * @return float
     */
    public function getKmDepart()
    {
        return $this->kmDepart;
    }

    /**
     * Set niveauCarburant
     *
     * @param string $niveauCarburant
     *
     * @return CSR
     */
    public function setNiveauCarburant($niveauCarburant)
    {
        $this->niveauCarburant = $niveauCarburant;

        return $this;
    }

    /**
     * Get niveauCarburant
     *
     * @return string
     */
    public function getNiveauCarburant()
    {
        return $this->niveauCarburant;
    }

    /**
     * Set tarif
     *
     * @param float $tarif
     *
     * @return CSR
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return float
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set recette
     *
     * @param float $recette
     *
     * @return CSR
     */
    public function setRecette($recette)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return float
     */
    public function getRecette()
    {
        return $this->recette;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return CSR
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set conducteur1
     *
     * @param \LV\LocationBundle\Entity\Client $conducteur1
     *
     * @return CSR
     */
    public function setConducteur1(\LV\LocationBundle\Entity\Client $conducteur1)
    {
        $this->conducteur1 = $conducteur1;

        return $this;
    }

    /**
     * Get conducteur1
     *
     * @return \LV\LocationBundle\Entity\Client
     */
    public function getConducteur1()
    {
        return $this->conducteur1;
    }

    /**
     * Set conducteur2
     *
     * @param \LV\LocationBundle\Entity\Client $conducteur2
     *
     * @return CSR
     */
    public function setConducteur2(\LV\LocationBundle\Entity\Client $conducteur2)
    {
        $this->conducteur2 = $conducteur2;

        return $this;
    }

    /**
     * Get conducteur2
     *
     * @return \LV\LocationBundle\Entity\Client
     */
    public function getConducteur2()
    {
        return $this->conducteur2;
    }

    /**
     * Set refVoiture
     *
     * @param \LV\LocationBundle\Entity\Voiture $refVoiture
     *
     * @return CSR
     */
    public function setRefVoiture(\LV\LocationBundle\Entity\Voiture $refVoiture)
    {
        $this->refVoiture = $refVoiture;

        return $this;
    }

    /**
     * Get refVoiture
     *
     * @return \LV\LocationBundle\Entity\Voiture
     */
    public function getRefVoiture()
    {
        return $this->refVoiture;
    }

    /**
     * Set refReservation
     *
     * @param \LV\LocationBundle\Entity\Reservation $refReservation
     *
     * @return CSR
     */
    public function setRefReservation(\LV\LocationBundle\Entity\Reservation $refReservation = null)
    {
        $this->refReservation = $refReservation;
    
        return $this;
    }

    /**
     * Get refReservation
     *
     * @return \LV\LocationBundle\Entity\Reservation
     */
    public function getRefReservation()
    {
        return $this->refReservation;
    }

    /**
     * Set kmRetour
     *
     * @param float $kmRetour
     *
     * @return CSR
     */
    public function setKmRetour($kmRetour)
    {
        $this->kmRetour = $kmRetour;
    
        return $this;
    }

    /**
     * Get kmRetour
     *
     * @return float
     */
    public function getKmRetour()
    {
        return $this->kmRetour;
    }

    /**
     * Set garant
     *
     * @param float $garant
     *
     * @return CSR
     */
    public function setGarant($garant)
    {
        $this->garant = $garant;
    
        return $this;
    }

    /**
     * Get garant
     *
     * @return float
     */
    public function getGarant()
    {
        return $this->garant;
    }

    /**
     * Set fraisAeroport
     *
     * @param float $fraisAeroport
     *
     * @return CSR
     */
    public function setFraisAeroport($fraisAeroport)
    {
        $this->fraisAeroport = $fraisAeroport;
    
        return $this;
    }

    /**
     * Get fraisAeroport
     *
     * @return float
     */
    public function getFraisAeroport()
    {
        return $this->fraisAeroport;
    }

    /**
     * Set siegeBebe
     *
     * @param float $siegeBebe
     *
     * @return CSR
     */
    public function setSiegeBebe($siegeBebe)
    {
        $this->siegeBebe = $siegeBebe;
    
        return $this;
    }

    /**
     * Get siegeBebe
     *
     * @return float
     */
    public function getSiegeBebe()
    {
        return $this->siegeBebe;
    }

    /**
     * Set supplement
     *
     * @param float $supplement
     *
     * @return CSR
     */
    public function setSupplement($supplement)
    {
        $this->supplement = $supplement;
    
        return $this;
    }

    /**
     * Get supplement
     *
     * @return float
     */
    public function getSupplement()
    {
        return $this->supplement;
    }

    /**
     * Set carburant
     *
     * @param float $carburant
     *
     * @return CSR
     */
    public function setCarburant($carburant)
    {
        $this->carburant = $carburant;
    
        return $this;
    }

    /**
     * Get carburant
     *
     * @return float
     */
    public function getCarburant()
    {
        return $this->carburant;
    }

    /**
     * Set totalHTVA
     *
     * @param float $totalHTVA
     *
     * @return CSR
     */
    public function setTotalHTVA($totalHTVA)
    {
        $this->totalHTVA = $totalHTVA;
    
        return $this;
    }

    /**
     * Get totalHTVA
     *
     * @return float
     */
    public function getTotalHTVA()
    {
        return $this->totalHTVA;
    }

    /**
     * Set tVA
     *
     * @param float $tVA
     *
     * @return CSR
     */
    public function setTVA($tVA)
    {
        $this->TVA = $tVA;
    
        return $this;
    }

    /**
     * Get tVA
     *
     * @return float
     */
    public function getTVA()
    {
        return $this->TVA;
    }

    /**
     * Set sousTotal
     *
     * @param float $sousTotal
     *
     * @return CSR
     */
    public function setSousTotal($sousTotal)
    {
        $this->sousTotal = $sousTotal;
    
        return $this;
    }

    /**
     * Get sousTotal
     *
     * @return float
     */
    public function getSousTotal()
    {
        return $this->sousTotal;
    }

    /**
     * Set timbre
     *
     * @param float $timbre
     *
     * @return CSR
     */
    public function setTimbre($timbre)
    {
        $this->timbre = $timbre;
    
        return $this;
    }

    /**
     * Get timbre
     *
     * @return float
     */
    public function getTimbre()
    {
        return $this->timbre;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return CSR
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set etatRetour
     *
     * @param string $etatRetour
     *
     * @return CSR
     */
    public function setEtatRetour($etatRetour)
    {
        $this->etatRetour = $etatRetour;
    
        return $this;
    }

    /**
     * Get etatRetour
     *
     * @return string
     */
    public function getEtatRetour()
    {
        return $this->etatRetour;
    }

    /**
     * Set degats
     *
     * @param boolean $degats
     *
     * @return CSR
     */
    public function setDegats($degats)
    {
        $this->degats = $degats;
    
        return $this;
    }

    /**
     * Get degats
     *
     * @return boolean
     */
    public function getDegats()
    {
        return $this->degats;
    }
}
