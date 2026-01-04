<?php

namespace LV\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * TypeDepenses
 *
 * @ORM\Table(name="type_depenses")
 * @ORM\Entity(repositoryClass="LV\LocationBundle\Repository\TypeDepensesRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity("label", message="Nom déjà existant")
 */
class TypeDepenses
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
     * @ORM\Column(name="label", type="string", length=255)
     * @Assert\NotBlank(message="Valeur obligatoire")
     */
    private $label;
   
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
     * Set label
     *
     * @param string $label
     *
     * @return TypeDepenses
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

}
