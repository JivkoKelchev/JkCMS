<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Positions
 *
 * @ORM\Table(name="positions")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\PositionsRepository")
 */
class Positions
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
     * @ORM\Column(name="row_id", type="integer")
     */
    private $rowId;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;

    /**
     * @var Styles
     * @ORM\OneToOne(targetEntity="CMSBundle\Entity\Styles", mappedBy="position")
     */
    private $style;

    /**
     * @var Rows;
     * @ORM\ManyToOne(targetEntity="CMSBundle\Entity\Rows", inversedBy="positions")
     */
    private $row;

    /**
     * @var ElementType
     * @ORM\ManyToOne(targetEntity="CMSBundle\Entity\ElementType", inversedBy="positions")
     */
    private $elementType;



    /**
     * @return Rows
     */
    public function getRow(): Rows
    {
        return $this->row;
    }

    /**
     * @param Rows $row
     */
    public function setRow(Rows $row)
    {
        $this->row = $row;
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
     * Set rowId
     *
     * @param integer $rowId
     */
    public function setRowId($rowId)
    {
        $this->rowId = $rowId;
    }

    /**
     * Get rowId
     *
     * @return int
     */
    public function getRowId()
    {
        return $this->rowId;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return positions
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return ElementType
     */
    public function getElementType()
    {
        return $this->elementType;
    }

    /**
     * @param ElementType $elementType
     */
    public function setElementType(ElementType $elementType)
    {
        $this->elementType = $elementType;
    }

    /**
     * @return Styles
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param Styles $style
     */
    public function setStyle(Styles $style)
    {
        $this->style = $style;
    }




}

