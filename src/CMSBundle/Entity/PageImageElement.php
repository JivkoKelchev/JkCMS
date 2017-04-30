<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageImageElement
 *
 * @ORM\Table(name="page_image_element")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\PageImageElementRepository")
 */
class PageImageElement
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
     * @ORM\Column(name="position_id", type="integer")
     */
    private $positionId;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;


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
     * Set height
     *
     * @param integer $height
     *
     * @return PageImageElement
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return PageImageElement
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getPositionId(): int
    {
        return $this->positionId;
    }

    /**
     * @param int $positionId
     */
    public function setPositionId(int $positionId)
    {
        $this->positionId = $positionId;
    }
}

