<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Modele
 *
 * @ORM\Table(name="modele")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\ModeleRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("nom", message="Modèle déjà existant")
 */
class Modele
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $nom;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Modele
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
     * Set marque
     *
     * @param \LV\LocationBundle\Entity\Marque $marque
     *
     * @return Modele
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

    public function __toString()
    {
        return $this->nom;
    }
}
