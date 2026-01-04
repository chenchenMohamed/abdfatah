<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\ReservationRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numReservation", message="Numéro déjà existant")
 */
class Reservation
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
     * @var String
     *
     * @ORM\Column(name="numReservation", type="string", unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $numReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateResevation", type="datetime")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $dateResevation;

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
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="nbreJour", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nbreJour;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Voiture")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refVoiture;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refClient;


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
     * Set numReservation
     *
     * @param integer $numReservation
     *
     * @return Reservation
     */
    public function setNumReservation($numReservation)
    {
        $this->numReservation = $numReservation;

        return $this;
    }

    /**
     * Get numReservation
     *
     * @return int
     */
    public function getNumReservation()
    {
        return $this->numReservation;
    }


    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Reservation
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
     * Set nbreJour
     *
     * @param integer $nbreJour
     *
     * @return Reservation
     */
    public function setNbreJour($nbreJour)
    {
        $this->nbreJour = $nbreJour;

        return $this;
    }

    /**
     * Get nbreJour
     *
     * @return int
     */
    public function getNbreJour()
    {
        return $this->nbreJour;
    }

    /**
     * Set refVoiture
     *
     * @param string $refVoiture
     *
     * @return Reservation
     */
    public function setRefVoiture($refVoiture)
    {
        $this->refVoiture = $refVoiture;

        return $this;
    }

    /**
     * Get refVoiture
     *
     * @return string
     */
    public function getRefVoiture()
    {
        return $this->refVoiture;
    }

    /**
     * Set refClient
     *
     * @param integer $refClient
     *
     * @return Reservation
     */
    public function setRefClient($refClient)
    {
        $this->refClient = $refClient;

        return $this;
    }

    /**
     * Get refClient
     *
     * @return int
     */
    public function getRefClient()
    {
        return $this->refClient;
    }

    /**
     * Set dateFin
     *
     * @param string $dateFin
     *
     * @return Reservation
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return string
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set dateResevation
     *
     * @param string $dateResevation
     *
     * @return Reservation
     */
    public function setDateResevation($dateResevation)
    {
        $this->dateResevation = $dateResevation;

        return $this;
    }

    /**
     * Get dateResevation
     *
     * @return string
     */
    public function getDateResevation()
    {
        return $this->dateResevation;
    }

    

}
