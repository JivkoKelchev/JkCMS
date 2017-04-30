<?php

namespace CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * PageCategories
 *
 * @ORM\Table(name="page_categories")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\PageCategoriesRepository")
 * @UniqueEntity(fields={"name"}, message="There is category with this name ")
 */
class PageCategories
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
     *
     *  @Assert\NotBlank()
     *
     */
    private $name;

    /**
     * @var Pages[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="CMSBundle\Entity\Pages", mappedBy="pageCategory")
     */
    private $pages;







    public function __construct()
    {
        $this->pages = new ArrayCollection();
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
     * @return PageCategories
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
     * @return Pages[]|ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Pages[]|ArrayCollection $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

}

