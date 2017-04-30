<?php

namespace CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Navbar
 *
 * @ORM\Table(name="navbar")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\NavbarRepository")
 */
class Navbar
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
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    private $logoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="categories_links", type="string", length=255, nullable=true)
     */
    private $categories;

    /**
     * @var array
     *
     * @ORM\Column(name="single_link", type="json_array", nullable=true)
     */
    private $singleLink;

    private $sl;

    /**
     * @var bool
     *
     * @ORM\Column(name="search_by_tags", type="boolean")
     */
    private $searchByTags;

    /**
     * @var bool
     *
     * @ORM\Column(name="log_in_out", type="boolean")
     */
    private $logInOut;






    public function __construct()
    {
        $this->links = new ArrayCollection();
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
     * Set brand
     *
     * @param string $brand
     *
     * @return Navbar
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Navbar
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set categories
     *
     * @param string $categories
     *
     * @return Navbar
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return string
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set singleLink
     *
     * @param array $singleLink
     *
     * @return Navbar
     */
    public function setSingleLink($singleLink)
    {
        $this->singleLink = $singleLink;

        return $this;
    }

    /**
     * Get singleLink
     *
     * @return array
     */
    public function getSingleLink()
    {
        return $this->singleLink;
    }

    /**
     * Set searchByTags
     *
     * @param boolean $searchByTags
     *
     * @return Navbar
     */
    public function setSearchByTags($searchByTags)
    {
        $this->searchByTags = $searchByTags;

        return $this;
    }

    /**
     * Get searchByTags
     *
     * @return bool
     */
    public function getSearchByTags()
    {
        return $this->searchByTags;
    }

    /**
     * Set logInOut
     *
     * @param boolean $logInOut
     *
     * @return Navbar
     */
    public function setLogInOut($logInOut)
    {
        $this->logInOut = $logInOut;

        return $this;
    }

    /**
     * Get logInOut
     *
     * @return bool
     */
    public function getLogInOut()
    {
        return $this->logInOut;
    }

    /**
     * @return mixed
     */
    public function getSl()
    {
        return $this->sl;
    }

    /**
     * @param mixed $sl
     */
    public function setSl($sl)
    {
        $this->sl = $sl;
    }

    /**
     * @return mixed
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * @param mixed $logoFile
     */
    public function setLogoFile($logoFile)
    {
        $this->logoFile = $logoFile;
    }


}

