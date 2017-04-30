<?php

namespace CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pages
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\PagesRepository")
 */
class Pages
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    private $imageFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Rows[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="CMSBundle\Entity\Rows", mappedBy="page")
     */
    private $raws;

    /**
     * @var Comments[]| ArrayCollection
     * @ORM\OneToMany(targetEntity="CMSBundle\Entity\Comments", mappedBy="page")
     */
    private $comments;

    /**
     * @var Tags[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="CMSBundle\Entity\Tags", inversedBy="page")
     */
    private $tags;

    /**
     * @var PageCategories
     * @ORM\ManyToOne(targetEntity="CMSBundle\Entity\PageCategories", inversedBy="pages")
     */
    private $pageCategory;

    private $newTagName;







    public function __construct()
    {
        $this->date = new \DateTime('now');
        $this->raws = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return Rows[]|ArrayCollection
     */
    public function getRaws()
    {
        return $this->raws;
    }

    /**
     * @param ArrayCollection $raws
     */
    public function setRaws(ArrayCollection $raws)
    {
        $this->raws = $raws;
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
     * Set title
     *
     * @param string $title
     *
     * @return pages
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return pages
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return pages
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return Comments[]|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comments[]|ArrayCollection $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return Tags[]|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tags[]|ArrayCollection $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function addTag(Tags $tag)
    {
        $tags = $this->getTags();
        if(!$tags->contains($tag)){
            $tags[]=$tag;
            $this->setTags($tags);
        }
    }

    public function removeTag(Tags $tag)
    {
        $this->getTags()->removeElement($tag);
    }



    /**
     * @return mixed
     */
    public function getNewTagName()
    {
        return $this->newTagName;
    }

    /**
     * @param mixed $newTagName
     */
    public function setNewTagName($newTagName)
    {
        $this->newTagName = $newTagName;
    }

    /**
     * @return PageCategories
     */
    public function getPageCategory()
    {
        return $this->pageCategory;
    }

    /**
     * @param PageCategories $pageCategory
     */
    public function setPageCategory( $pageCategory)
    {
        $this->pageCategory = $pageCategory;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }


}

