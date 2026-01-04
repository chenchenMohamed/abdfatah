<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Cheque
 *
 * @ORM\Table(name="cheque")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\ChequeRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numCheque", message="Numéro déjà existant")
 */
class Cheque
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
     * @ORM\Column(name="numCheque", type="integer", unique=true, nullable=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $numCheque;

    /**
     * @var string
     *
     * @ORM\Column(name="banque", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $banque;

    /**
     * @var float
     *
     * @ORM\Column(name="monatant", type="float", nullable=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $monatant;

    /**
     * @var string
     *
     * @ORM\Column(name="nomProp", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nomProp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateValidation", type="date", nullable=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $dateValidation;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true)
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
     * Set numCheque
     *
     * @param integer $numCheque
     *
     * @return Cheque
     */
    public function setNumCheque($numCheque)
    {
        $this->numCheque = $numCheque;

        return $this;
    }

    /**
     * Get numCheque
     *
     * @return int
     */
    public function getNumCheque()
    {
        return $this->numCheque;
    }

    /**
     * Set banque
     *
     * @param string $banque
     *
     * @return Cheque
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return string
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set monatant
     *
     * @param float $monatant
     *
     * @return Cheque
     */
    public function setMonatant($monatant)
    {
        $this->monatant = $monatant;

        return $this;
    }

    /**
     * Get monatant
     *
     * @return float
     */
    public function getMonatant()
    {
        return $this->monatant;
    }

    /**
     * Set nomProp
     *
     * @param string $nomProp
     *
     * @return Cheque
     */
    public function setNomProp($nomProp)
    {
        $this->nomProp = $nomProp;

        return $this;
    }

    /**
     * Get nomProp
     *
     * @return string
     */
    public function getNomProp()
    {
        return $this->nomProp;
    }

    /**
     * Set dateValidation
     *
     * @param \DateTime $dateValidation
     *
     * @return Cheque
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    /**
     * Get dateValidation
     *
     * @return \DateTime
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Cheque
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

    public function __toString()
    {
        return $this->dateValidation;
    }
}
