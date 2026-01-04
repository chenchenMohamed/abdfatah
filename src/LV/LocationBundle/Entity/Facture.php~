<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\FactureRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numFacture", message="Numéro déjà existant")
 */
class Facture
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
     * @ORM\Column(name="numFacture", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $numFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFacture", type="datetime")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $dateFacture;

    /**
     * @ORM\OneToOne(targetEntity="LV\LocationBundle\Entity\Paiement", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refPayement;


    

    


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numFacture
     *
     * @param integer $numFacture
     *
     * @return Facture
     */
    public function setNumFacture($numFacture)
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    /**
     * Get numFacture
     *
     * @return integer
     */
    public function getNumFacture()
    {
        return $this->numFacture;
    }

    /**
     * Set dateFacture
     *
     * @param \DateTime $dateFacture
     *
     * @return Facture
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    /**
     * Set refPayement
     *
     * @param \LV\LocationBundle\Entity\Paiement $refPayement
     *
     * @return Facture
     */
    public function setRefPayement(\LV\LocationBundle\Entity\Paiement $refPayement)
    {
        $this->refPayement = $refPayement;

        return $this;
    }

    /**
     * Get refPayement
     *
     * @return \LV\LocationBundle\Entity\Paiement
     */
    public function getRefPayement()
    {
        return $this->refPayement;
    }
}
