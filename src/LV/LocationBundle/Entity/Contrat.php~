<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\ContratRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numContrat", message="Contrat déjà existant")
 */
class Contrat
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
     * @ORM\Column(name="NumContrat", type="string", length=255, unique=true)
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
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $kmDepart;

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
     * @ORM\Column(name="recette", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $recette;


    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Reservation")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refReservation;

     /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $etat;

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
     * @param integer $numContrat
     *
     * @return Contrat
     */
    public function setNumContrat($numContrat)
    {
        $this->numContrat = $numContrat;

        return $this;
    }

    /**
     * Get numContrat
     *
     * @return int
     */
    public function getNumContrat()
    {
        return $this->numContrat;
    }

    /**
     * Set recette
     *
     * @param float $recette
     *
     * @return Contrat
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
     * Set dateContrat
     *
     * @param \DateTime $dateContrat
     *
     * @return Contrat
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
     * Set refReservation
     *
     * @param \LV\LocationBundle\Entity\Reservation $refReservation
     *
     * @return Contrat
     */
    public function setRefReservation(\LV\LocationBundle\Entity\Reservation $refReservation)
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
     * Set kmDepart
     *
     * @param float $kmDepart
     *
     * @return Contrat
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
     * @return Contrat
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Contrat
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
     * @return Contrat
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
     * @return Contrat
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
     * Set nbreJour
     *
     * @param string $nbreJour
     *
     * @return Contrat
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
     * Set tarif
     *
     * @param float $tarif
     *
     * @return Contrat
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
}
