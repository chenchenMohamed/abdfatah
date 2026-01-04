<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Assurance
 *
 * @ORM\Table(name="assurance")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\AssuranceRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numAssurance", message="Numéro déjà utilisé")
 */
class Assurance
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
     * @ORM\Column(name="numAssurance", type="integer", unique=true)
     */
    private $numAssurance;

    /**
     * @var string
     *
     * @ORM\Column(name="nomAssurance", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nomAssurance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAssurance", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Date non valide"
     * )
     */
    private $dateAssurance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateProchAssurance", type="date")
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
     *     "this.getDateAssurance() < this.getDateProchAssurance()",
     *     message="Date visite doît être inférieur au date proch visite"
     * )
     */
    private $dateProchAssurance;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $montant;

    /**
     * @ORM\ManyToMany(targetEntity="LV\LocationBundle\Entity\Voiture",cascade={"persist"})
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
     * Set numAssurance
     *
     * @param integer $numAssurance
     *
     * @return Assurance
     */
    public function setNumAssurance($numAssurance)
    {
        $this->numAssurance = $numAssurance;

        return $this;
    }

    /**
     * Get numAssurance
     *
     * @return int
     */
    public function getNumAssurance()
    {
        return $this->numAssurance;
    }

    /**
     * Set nomAssurance
     *
     * @param string $nomAssurance
     *
     * @return Assurance
     */
    public function setNomAssurance($nomAssurance)
    {
        $this->nomAssurance = $nomAssurance;

        return $this;
    }

    /**
     * Get nomAssurance
     *
     * @return string
     */
    public function getNomAssurance()
    {
        return $this->nomAssurance;
    }

    /**
     * Set dateAssurance
     *
     * @param \DateTime $dateAssurance
     *
     * @return Assurance
     */
    public function setDateAssurance($dateAssurance)
    {
        $this->dateAssurance = $dateAssurance;

        return $this;
    }

    /**
     * Get dateAssurance
     *
     * @return \DateTime
     */
    public function getDateAssurance()
    {
        return $this->dateAssurance;
    }

    /**
     * Set dateProchAssurance
     *
     * @param \DateTime $dateProchAssurance
     *
     * @return Assurance
     */
    public function setDateProchAssurance($dateProchAssurance)
    {
        $this->dateProchAssurance = $dateProchAssurance;

        return $this;
    }

    /**
     * Get dateProchAssurance
     *
     * @return \DateTime
     */
    public function getDateProchAssurance()
    {
        return $this->dateProchAssurance;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Assurance
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
     * @return Assurance
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
     * Constructor
     */
    public function __construct()
    {
        $this->refVoiture = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add refVoiture
     *
     * @param \LV\LocationBundle\Entity\Voiture $refVoiture
     *
     * @return Assurance
     */
    public function addRefVoiture(\LV\LocationBundle\Entity\Voiture $refVoiture)
    {
        $this->refVoiture[] = $refVoiture;

        return $this;
    }

    /**
     * Remove refVoiture
     *
     * @param \LV\LocationBundle\Entity\Voiture $refVoiture
     */
    public function removeRefVoiture(\LV\LocationBundle\Entity\Voiture $refVoiture)
    {
        $this->refVoiture->removeElement($refVoiture);
    }
}
