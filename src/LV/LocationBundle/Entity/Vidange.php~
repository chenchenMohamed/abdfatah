<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Vidange
 *
 * @ORM\Table(name="vidange")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\VidangeRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numVidange", message="Numéro déjà existant")
 */
class Vidange
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
     * @var int
     *
     * @ORM\Column(name="numVidange", type="integer", unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $numVidange;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVidange", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Date non valide"
     * )
     * @Assert\GreaterThanOrEqual(
     *      value = "today",
     *      message = "La date doît être sup ou égal à aujourdhui"
     * )
     */
    private $dateVidange;

    
    /**
     * @var int
     *
     * @ORM\Column(name="prochVidange", type="integer")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $prochVidange;

    /**
     * @var float
     *
     * @ORM\Column(name="compteur", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $compteur;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Voiture")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refVoiture;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $montant;



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
     * Set numVidange
     *
     * @param integer $numVidange
     *
     * @return Vidange
     */
    public function setNumVidange($numVidange)
    {
        $this->numVidange = $numVidange;

        return $this;
    }

    /**
     * Get numVidange
     *
     * @return int
     */
    public function getNumVidange()
    {
        return $this->numVidange;
    }

    /**
     * Set dateVidange
     *
     * @param \DateTime $dateVidange
     *
     * @return Vidange
     */
    public function setDateVidange($dateVidange)
    {
        $this->dateVidange = $dateVidange;

        return $this;
    }

    /**
     * Get dateVidange
     *
     * @return \DateTime
     */
    public function getDateVidange()
    {
        return $this->dateVidange;
    }

    /**
     * Set prochVidange
     *
     * @param integer $prochVidange
     *
     * @return Vidange
     */
    public function setProchVidange($prochVidange)
    {
        $this->prochVidange = $prochVidange;

        return $this;
    }

    /**
     * Get prochVidange
     *
     * @return integer
     */
    public function getProchVidange()
    {
        return $this->prochVidange;
    }

    /**
     * Set compteur
     *
     * @param float $compteur
     *
     * @return Vidange
     */
    public function setCompteur($compteur)
    {
        $this->compteur = $compteur;

        return $this;
    }

    /**
     * Get compteur
     *
     * @return float
     */
    public function getCompteur()
    {
        return $this->compteur;
    }

    /**
     * Set refVoiture
     *
     * @param string $refVoiture
     *
     * @return Vidange
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
     * Set montant
     *
     * @param float $montant
     *
     * @return Vidange
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }
}
