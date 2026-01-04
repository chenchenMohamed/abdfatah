<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Soustraitance
 *
 * @ORM\Table(name="soustraitance")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\SoustraitanceRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("numSoustraitance", message="Numéro déjà existant")
 */
class Soustraitance
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
     * @ORM\Column(name="numSoustraitance", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $numSoustraitance;

    /**
     * @var string
     *
     * @ORM\Column(name="nbrePayRestant", type="integer")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nbrePayRestant;

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
     * @ORM\Column(name="montantPaye", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $montantPaye;

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
     * @ORM\Column(name="montantRestant", type="float")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $montantRestant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePremierPay", type="date")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Date non valide"
	 *)
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
     *     message="Date premier pay doît être inférieur au date dernier pay"
     * )
     */
    private $dateDernierPay;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $etat;

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
     * Set numSoustraitance
     *
     * @param integer $numSoustraitance
     *
     * @return Soustraitance
     */
    public function setNumSoustraitance($numSoustraitance)
    {
        $this->numSoustraitance = $numSoustraitance;

        return $this;
    }

    /**
     * Get numSoustraitance
     *
     * @return int
     */
    public function getNumSoustraitance()
    {
        return $this->numSoustraitance;
    }

    /**
     * Set montantPaye
     *
     * @param float $montantPaye
     *
     * @return Soustraitance
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
     * Set monatntMensuel
     *
     * @param float $monatntMensuel
     *
     * @return Soustraitance
     */
    public function setMonatntMensuel($monatntMensuel)
    {
        $this->monatntMensuel = $monatntMensuel;

        return $this;
    }

    /**
     * Get monatntMensuel
     *
     * @return float
     */
    public function getMonatntMensuel()
    {
        return $this->monatntMensuel;
    }

    /**
     * Set montnatRestant
     *
     * @param float $montnatRestant
     *
     * @return Soustraitance
     */
    public function setMontnatRestant($montnatRestant)
    {
        $this->montnatRestant = $montnatRestant;

        return $this;
    }

    /**
     * Get montnatRestant
     *
     * @return float
     */
    public function getMontnatRestant()
    {
        return $this->montnatRestant;
    }

    /**
     * Set datePremierPay
     *
     * @param \DateTime $datePremierPay
     *
     * @return Soustraitance
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Soustraitance
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
     * Set refVoiture
     *
     * @param string $refVoiture
     *
     * @return Soustraitance
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
     * Set nbrePayRestant
     *
     * @param integer $nbrePayRestant
     *
     * @return Soustraitance
     */
    public function setNbrePayRestant($nbrePayRestant)
    {
        $this->nbrePayRestant = $nbrePayRestant;

        return $this;
    }

    /**
     * Get nbrePayRestant
     *
     * @return integer
     */
    public function getNbrePayRestant()
    {
        return $this->nbrePayRestant;
    }

    /**
     * Set montantTotal
     *
     * @param float $montantTotal
     *
     * @return Soustraitance
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
     * @return Soustraitance
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

    /**
     * Set montantRestant
     *
     * @param float $montantRestant
     *
     * @return Soustraitance
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
     * Set dateDernierPay
     *
     * @param \DateTime $dateDernierPay
     *
     * @return Soustraitance
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
     * Set refClient
     *
     * @param \LV\LocationBundle\Entity\Client $refClient
     *
     * @return Soustraitance
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
}
