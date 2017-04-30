<?php

namespace CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rows
 *
 * @ORM\Table(name="rows")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\RowsRepository")
 */
class Rows
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
     * @ORM\Column(name="page_id", type="integer")
     */
    private $pageId;

    /**
     * @var Pages
     * @ORM\ManyToOne(targetEntity="CMSBundle\Entity\Pages", inversedBy="raws")
     */
    private $page;

    /**
     * @var Positions[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="CMSBundle\Entity\Positions", mappedBy="row")
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
     * @return Pages
     */
    public function getPage(): Pages
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
     * Set pageId
     *
     * @param integer $pageId
     *
     * @return rows
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * Get pageId
     *
     * @return int
     */
    public function getPageId()
    {
        return $this->pageId;
    }
}

