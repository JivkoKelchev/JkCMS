<?php

namespace CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ElementType
 *
 * @ORM\Table(name="element_type")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\ElementTypeRepository")
 */
class ElementType
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
     * @ORM\Column(name="type", type="string", length=255, unique=true)
     */
    private $type;

    /**
     * @var Positions[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="CMSBundle\Entity\Positions", mappedBy="elementType")
     */
    private $positions;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    /**
     * @return Positions[]|ArrayCollection
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param Positions[]|ArrayCollection $positions
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;
    }


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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}

