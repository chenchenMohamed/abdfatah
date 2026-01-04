<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PaiementEcheance
 *
 * @ORM\Table(name="paiement_echeance")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\PaiementEcheanceRepository")
 */
class PaiementEcheance
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
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Echeance", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refEcheance;


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
     * @return PaiementEcheance
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
     * @return PaiementEcheance
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
     * Set refEcheance
     *
     * @param \LV\LocationBundle\Entity\Echeance $refEcheance
     *
     * @return PaiementEcheance
     */
    public function setRefEcheance(\LV\LocationBundle\Entity\Echeance $refEcheance)
    {
        $this->refEcheance = $refEcheance;

        return $this;
    }

    /**
     * Get refEcheance
     *
     * @return \LV\LocationBundle\Entity\Echeance
     */
    public function getRefEcheance()
    {
        return $this->refEcheance;
    }
}
