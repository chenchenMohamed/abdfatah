<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * PaiementSoustraitance
 *
 * @ORM\Table(name="paiement_soustraitance")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\PaiementSoustraitanceRepository")
 */
class PaiementSoustraitance
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Soustraitance", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refSoustraitance;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PaiementSoustraitance
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return PaiementSoustraitance
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
     * Set refSoustraitance
     *
     * @param string $refSoustraitance
     *
     * @return PaiementSoustraitance
     */
    public function setRefSoustraitance($refSoustraitance)
    {
        $this->refSoustraitance = $refSoustraitance;

        return $this;
    }

    /**
     * Get refSoustraitance
     *
     * @return string
     */
    public function getRefSoustraitance()
    {
        return $this->refSoustraitance;
    }
}
