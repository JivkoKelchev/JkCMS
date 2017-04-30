<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentsElement
 *
 * @ORM\Table(name="comments_element")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\commentsElementRepository")
 */
class CommentsElement
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
     * @ORM\Column(name="positionId", type="integer", unique=true)
     */
    private $positionId;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content = '<br> comments list';

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
     * @return commentsElement
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
     * @return commentsElement
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

