<?php

namespace CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\tagsRepository")
 * @UniqueEntity(fields={"name"}, message="There is tag with this name ")
 */
class Tags
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var Pages[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="CMSBundle\Entity\Pages", mappedBy="tags")
     */
    private $page;









    public function __construct()
    {
        $this->page = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return tags
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Pages[]
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Pages $page
     */
    public function setPage(Pages $page)
    {
        $this->page = $page;
    }

}

