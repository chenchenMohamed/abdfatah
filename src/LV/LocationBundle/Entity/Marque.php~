<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Marque
 *
 * @ORM\Table(name="marque")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\MarqueRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("nom", message="Marque déjà existante")
 */
class Marque
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
     *@ORM\OneToMany(targetEntity="LV\LocationBundle\Entity\Modele", mappedBy="marque")
     *@Assert\NotBlank(message="Valeur obligatoire")
     */
    private $modeles;


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
     * @return Marque
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
     * Constructor
     */
    public function __construct()
    {
        $this->modeles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add modele
     *
     * @param \LV\LocationBundle\Entity\Modele $modele
     *
     * @return Marque
     */
    public function addModele(\LV\LocationBundle\Entity\Modele $modele)
    {
        $this->modeles[] = $modele;

        return $this;
    }

    /**
     * Remove modele
     *
     * @param \LV\LocationBundle\Entity\Modele $modele
     */
    public function removeModele(\LV\LocationBundle\Entity\Modele $modele)
    {
        $this->modeles->removeElement($modele);
    }

    /**
     * Get modeles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModeles()
    {
        return $this->modeles;
    }

     public function __toString()
    {
        return $this->nom;
    }
}
