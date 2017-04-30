<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactElement
 *
 * @ORM\Table(name="contact_element")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\ContactElementRepository")
 */
class ContactElement
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
     * @ORM\Column(name="content", type="text")
     */
    private $content = '<br> Form to send emails to:';


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
     * Set content
     *
     * @param string $content
     *
     * @return ContactElement
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

