<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Echeance
 *
 * @ORM\Table(name="echeance")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\EcheanceRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("contartLeasing", message="Contrat déjà existant")
 */
class Echeance
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
     * @var float
     *
     * @ORM\Column(name="montantTotal", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $montantTotal;

    /**
     * @var float
     *
     * @ORM\Column(name="montantMensuel", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $montantMensuel;

    /**
     * @var float
     *
     * @ORM\Column(name="montantPaye", type="float")
     */
    private $montantPaye;

    /**
     * @var float
     *
     * @ORM\Column(name="montantRestant", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $montantRestant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DatePremierPay", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Date non valide"
     * )
     */
    private $datePremierPay;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDernierPay", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Date non valide"
     * )
     * @Assert\Expression(
     *     "this.getDatePremierPay() < this.getDateDernierPay()",
     *     message="Date pay doît être inférieur au date proch pay"
     * )
     */
    private $dateDernierPay;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrePayRestant", type="integer")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nbrePayRestant;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="contartLeasing", type="integer", unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $contartLeasing;

    /**
     * @var string
     *
     * @ORM\Column(name="nomLeasing", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nomLeasing;

    /**
     * @ORM\OneToOne(targetEntity="LV\LocationBundle\Entity\Voiture", cascade={"persist"})
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
     * Set montantPaye
     *
     * @param float $montantPaye
     *
     * @return Echeance
     */
    public function setMontantPaye($montantPaye)
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    /**
     * Get montantPaye
     *
     * @return float
     */
    public function getMontantPaye()
    {
        return $this->montantPaye;
    }

    /**
     * Set montantRestant
     *
     * @param float $montantRestant
     *
     * @return Echeance
     */
    public function setMontantRestant($montantRestant)
    {
        $this->montantRestant = $montantRestant;

        return $this;
    }

    /**
     * Get montantRestant
     *
     * @return float
     */
    public function getMontantRestant()
    {
        return $this->montantRestant;
    }

    /**
     * Set datePremierPay
     *
     * @param \DateTime $datePremierPay
     *
     * @return Echeance
     */
    public function setDatePremierPay($datePremierPay)
    {
        $this->datePremierPay = $datePremierPay;

        return $this;
    }

    /**
     * Get datePremierPay
     *
     * @return \DateTime
     */
    public function getDatePremierPay()
    {
        return $this->datePremierPay;
    }

    /**
     * Set dateDernierPay
     *
     * @param \DateTime $dateDernierPay
     *
     * @return Echeance
     */
    public function setDateDernierPay($dateDernierPay)
    {
        $this->dateDernierPay = $dateDernierPay;

        return $this;
    }

    /**
     * Get dateDernierPay
     *
     * @return \DateTime
     */
    public function getDateDernierPay()
    {
        return $this->dateDernierPay;
    }

    /**
     * Set nbrePayRestant
     *
     * @param integer $nbrePayRestant
     *
     * @return Echeance
     */
    public function setNbrePayRestant($nbrePayRestant)
    {
        $this->nbrePayRestant = $nbrePayRestant;

        return $this;
    }

    /**
     * Get nbrePayRestant
     *
     * @return int
     */
    public function getNbrePayRestant()
    {
        return $this->nbrePayRestant;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Echeance
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
     * Set contartLeasing
     *
     * @param integer $contartLeasing
     *
     * @return Echeance
     */
    public function setContartLeasing($contartLeasing)
    {
        $this->contartLeasing = $contartLeasing;

        return $this;
    }

    /**
     * Get contartLeasing
     *
     * @return int
     */
    public function getContartLeasing()
    {
        return $this->contartLeasing;
    }

    /**
     * Set nomLeasing
     *
     * @param string $nomLeasing
     *
     * @return Echeance
     */
    public function setNomLeasing($nomLeasing)
    {
        $this->nomLeasing = $nomLeasing;

        return $this;
    }

    /**
     * Get nomLeasing
     *
     * @return string
     */
    public function getNomLeasing()
    {
        return $this->nomLeasing;
    }

    /**
     * Set refVoiture
     *
     * @param string $refVoiture
     *
     * @return Echeance
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
     * Set montantTotal
     *
     * @param float $montantTotal
     *
     * @return Echeance
     */
    public function setMontantTotal($montantTotal)
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    /**
     * Get montantTotal
     *
     * @return float
     */
    public function getMontantTotal()
    {
        return $this->montantTotal;
    }

    /**
     * Set montantMensuel
     *
     * @param float $montantMensuel
     *
     * @return Echeance
     */
    public function setMontantMensuel($montantMensuel)
    {
        $this->montantMensuel = $montantMensuel;

        return $this;
    }

    /**
     * Get montantMensuel
     *
     * @return float
     */
    public function getMontantMensuel()
    {
        return $this->montantMensuel;
    }
}
