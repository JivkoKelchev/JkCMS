<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TextElement
 *
 * @ORM\Table(name="text_element")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\TextElementRepository")
 */
class TextElement
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content = '<br> Add Text';


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
     * Set positionId
     *
     * @param integer $positionId
     *
     * @return TextElement
     */
    public function setPositionId($positionId)
    {
        $this->positionId = $positionId;

        return $this;
    }

    /**
     * Get positionId
     *
     * @return int
     */
    public function getPositionId()
    {
        return $this->positionId;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return TextElement
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

}

