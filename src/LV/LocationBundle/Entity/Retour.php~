<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Retour
 *
 * @ORM\Table(name="retour")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\RetourRepository")
 */
class Retour
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
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refClient;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Voiture")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $refVoiture;

    /**
     * @ORM\OneToOne(targetEntity="LV\LocationBundle\Entity\Contrat")
     * @ORM\JoinColumn(nullable=TRUE)
     */
    private $refContrat;

    /**
     * @ORM\OneToOne(targetEntity="LV\LocationBundle\Entity\CSR")
     * @ORM\JoinColumn(nullable=TRUE)
     */
    private $refCsr;

    /**
     * @var int
     *
     * @ORM\Column(name="km", type="integer")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $km;

    /**
     * @var bool
     *
     * @ORM\Column(name="degats", type="boolean")
     */
    private $degats;

    /**
     * @var string
     *
     * @ORM\Column(name="etatRetour", type="string", length=255, nullable=true)
     */
    private $etatRetour;



   

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
     * Set km
     *
     * @param integer $km
     *
     * @return Retour
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return integer
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set degats
     *
     * @param boolean $degats
     *
     * @return Retour
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

    /**
     * Set refClient
     *
     * @param \LV\LocationBundle\Entity\Client $refClient
     *
     * @return Retour
     */
    public function setRefClient(\LV\LocationBundle\Entity\Client $refClient)
    {
        $this->refClient = $refClient;

        return $this;
    }

    /**
     * Get refClient
     *
     * @return \LV\LocationBundle\Entity\Client
     */
    public function getRefClient()
    {
        return $this->refClient;
    }

    /**
     * Set refVoiture
     *
     * @param \LV\LocationBundle\Entity\Voiture $refVoiture
     *
     * @return Retour
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
     * Set refContrat
     *
     * @param \LV\LocationBundle\Entity\Contrat $refContrat
     *
     * @return Retour
     */
    public function setRefContrat(\LV\LocationBundle\Entity\Contrat $refContrat)
    {
        $this->refContrat = $refContrat;

        return $this;
    }

    /**
     * Get refContrat
     *
     * @return \LV\LocationBundle\Entity\Contrat
     */
    public function getRefContrat()
    {
        return $this->refContrat;
    }

    /**
     * Set etatRetour
     *
     * @param string $etatRetour
     *
     * @return Retour
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
     * Set refCsr
     *
     * @param \LV\LocationBundle\Entity\CSR $refCsr
     *
     * @return Retour
     */
    public function setRefCsr(\LV\LocationBundle\Entity\CSR $refCsr = null)
    {
        $this->refCsr = $refCsr;

        return $this;
    }

    /**
     * Get refCsr
     *
     * @return \LV\LocationBundle\Entity\CSR
     */
    public function getRefCsr()
    {
        return $this->refCsr;
    }
}
