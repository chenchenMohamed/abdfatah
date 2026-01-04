<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\VoitureRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("matricule", message="Voiture déjà existante")
 */
class Voiture
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
     * @ORM\Column(name="km", type="integer", nullable=false)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $km;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\Regex(
     *     pattern="/^[0-9]{1,4}(T|t){1}(U|u){1}[0-9]{1,4}/",
     *     message="L'immatriculation doît être de forme ---TU---"
     * )
     */
    private $matricule;

    /**
     *
     *@ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Marque")
     *@ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marque_id", referencedColumnName="id")
     * })
     *@Assert\NotBlank(message="Valeur obligatoire")
     */
    private $marque;

    /**
     *
     *@ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Modele")
     *@ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modele_id", referencedColumnName="id")
     * })
     *@Assert\NotBlank(message="Valeur obligatoire")
     */
    private $modele;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="codeRadio", type="string", length=255, nullable=true)
     */
    private $codeRadio;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg","image/png","image/jpg" })
     */
    private $photo;

    /**
     * @var bool
     *
     * @ORM\Column(name="disponibilite", type="boolean", nullable=true)
     */
    private $disponibilite;

    /**
     * @var string
     *
     * @ORM\Column(name="fournisseur", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $fournisseur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="miseEnCirculation", type="datetime")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $miseEnCirculation;

    /**
     * @var int
     *
     * @ORM\Column(name="numContrat", type="integer")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $numContrat;

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
     *     message="Date premier pay doît être inférieur au date dernier pay"
     * )
     */
    private $dateDernierPay;

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
     * @ORM\Column(name="autoFinancement", type="float", nullable=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $autoFinancement;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrePayRestant", type="integer")
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nbrePayRestant;

    /**
     * @var float
     *
     * @ORM\Column(name="totalDepenses", type="float")
     * @Assert\GreaterThan(value=0, message="Valeur non valide")
     */
    private $totalDepenses;

    /**
     * @var bool
     *
     * @ORM\Column(name="isEnable", type="boolean", nullable=true)
     */
    private $isEnable;


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
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Voiture
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set modele
     *
     * @param string $modele
     *
     * @return Voiture
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Voiture
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set codeRadio
     *
     * @param string $codeRadio
     *
     * @return Voiture
     */
    public function setCodeRadio($codeRadio)
    {
        $this->codeRadio = $codeRadio;

        return $this;
    }

    /**
     * Get codeRadio
     *
     * @return string
     */
    public function getCodeRadio()
    {
        return $this->codeRadio;
    }

    /**
     * Set marque
     *
     * @param \LV\LocationBundle\Entity\Marque $marque
     *
     * @return Voiture
     */
    public function setMarque(\LV\LocationBundle\Entity\Marque $marque = null)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \LV\LocationBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Voiture
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }
    public function __toString()
    {
        return $this->marque . ' ' . $this->modele. ' ' . $this->couleur . ' ' . $this->matricule;
    }

    /**
     * Set km
     *
     * @param integer $km
     *
     * @return Voiture
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Voiture
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
     * Set photo
     *
     * @param string $photo
     *
     * @return Conducteur
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set disponibilite
     *
     * @param boolean $disponibilite
     *
     * @return Voiture
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
    
        return $this;
    }

    /**
     * Get disponibilite
     *
     * @return boolean
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * Set fournisseur
     *
     * @param string $fournisseur
     *
     * @return Voiture
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    
        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return string
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set miseEnCirculation
     *
     * @param \DateTime $miseEnCirculation
     *
     * @return Voiture
     */
    public function setMiseEnCirculation($miseEnCirculation)
    {
        $this->miseEnCirculation = $miseEnCirculation;
    
        return $this;
    }

    /**
     * Get miseEnCirculation
     *
     * @return \DateTime
     */
    public function getMiseEnCirculation()
    {
        return $this->miseEnCirculation;
    }

    /**
     * Set numContrat
     *
     * @param integer $numContrat
     *
     * @return Voiture
     */
    public function setNumContrat($numContrat)
    {
        $this->numContrat = $numContrat;
    
        return $this;
    }

    /**
     * Get numContrat
     *
     * @return integer
     */
    public function getNumContrat()
    {
        return $this->numContrat;
    }

    /**
     * Set datePremierPay
     *
     * @param \DateTime $datePremierPay
     *
     * @return Voiture
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
     * @return Voiture
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
     * Set montantTotal
     *
     * @param float $montantTotal
     *
     * @return Voiture
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
     * @return Voiture
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
     * Set autoFinancement
     *
     * @param float $autoFinancement
     *
     * @return Voiture
     */
    public function setAutoFinancement($autoFinancement)
    {
        $this->autoFinancement = $autoFinancement;
    
        return $this;
    }

    /**
     * Get autoFinancement
     *
     * @return float
     */
    public function getAutoFinancement()
    {
        return $this->autoFinancement;
    }

    /**
     * Set nbrePayRestant
     *
     * @param integer $nbrePayRestant
     *
     * @return Voiture
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
     * Set totalDepenses
     *
     * @param float $totalDepenses
     *
     * @return Voiture
     */
    public function setTotalDepenses($totalDepenses)
    {
        $this->totalDepenses = $totalDepenses;
    
        return $this;
    }

    /**
     * Get totalDepenses
     *
     * @return float
     */
    public function getTotalDepenses()
    {
        return $this->totalDepenses;
    }

    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     *
     * @return Voiture
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;
    
        return $this;
    }

    /**
     * Get isEnable
     *
     * @return boolean
     */
    public function getIsEnable()
    {
        return $this->isEnable;
    }
}
