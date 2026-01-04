<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Agence
 *
 * @ORM\Table(name="agence")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\AgenceRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("codeAgence", message="Code déjà utilisé")
 */
class Agence
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
     * @ORM\Column(name="codeAgence", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $codeAgence;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="tel2", type="string", length=255,nullable=true)
     */
    private $tel2;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255,nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nature;


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
     * Set codeAgence
     *
     * @param string $codeAgence
     *
     * @return Agence
     */
    public function setCodeAgence($codeAgence)
    {
        $this->codeAgence = $codeAgence;

        return $this;
    }

    /**
     * Get codeAgence
     *
     * @return string
     */
    public function getCodeAgence()
    {
        return $this->codeAgence;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Agence
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Agence
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set nature
     *
     * @param string $nature
     *
     * @return Agence
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Agence
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Agence
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set tel2
     *
     * @param string $tel2
     *
     * @return Agence
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;

        return $this;
    }

    /**
     * Get tel2
     *
     * @return string
     */
    public function getTel2()
    {
        return $this->tel2;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Agence
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }


    public function __toString()
    {
        return $this->nom;
    }
}
