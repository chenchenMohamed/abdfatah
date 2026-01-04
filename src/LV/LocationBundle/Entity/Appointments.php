<?php

namespace LV\LocationBundle\Entity;

/**
 * Appointments
 */
class Appointments
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="LV\LocationBundle\Entity\Reservation")
     * @Assert\NotBlank(message="Valeur obligatoire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $refReservation;


    
    
}