<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Visite
 *
 * @ORM\Table(name="visite")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\VisiteRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numVisite", message="Numéro déjà existant")
 */
class Visite
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
     * @ORM\Column(name="numVisite", type="integer", unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     * @Assert\Type(
     *     type="integer",
     *     message="La valeur doît être de type entier"
     * )
     */
    private $numVisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisite", type="date")
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
    private $dateVisite;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateProchVisite", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Date non valide"
     * )
     * @Assert\GreaterThanOrEqual(
     *      value = "today",
     *      message = "La date doît être sup ou égal à aujourdhui"
     *
     * )
     * @Assert\Expression(
     *     "this.getDateVisite() < this.getDateProchVisite()",
     *     message="Date visite doît être inférieur au date proch visite"
     * )
     */
    private $dateProchVisite;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     * @Assert\Type(
     *     type="float",
     *     message="La valeur doît être de type réelle"
     * )
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Voiture")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refVoiture;


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
     * Set numVisite
     *
     * @param integer $numVisite
     *
     * @return Visite
     */
    public function setNumVisite($numVisite)
    {
        $this->numVisite = $numVisite;

        return $this;
    }

    /**
     * Get numVisite
     *
     * @return int
     */
    public function getNumVisite()
    {
        return $this->numVisite;
    }

    /**
     * Set dateVisite
     *
     * @param \DateTime $dateVisite
     *
     * @return Visite
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Visite
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

    /**
     * Set refVoiture
     *
     * @param string $refVoiture
     *
     * @return Visite
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
     * Set dateProchVisite
     *
     * @param \DateTime $dateProchVisite
     *
     * @return Visite
     */
    public function setDateProchVisite($dateProchVisite)
    {
        $this->dateProchVisite = $dateProchVisite;

        return $this;
    }

    /**
     * Get dateProchVisite
     *
     * @return \DateTime
     */
    public function getDateProchVisite()
    {
        return $this->dateProchVisite;
    }
}
