<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PageListElement
 *
 * @ORM\Table(name="page_list_element")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\PageListElementRepository")
 */
class PageListElement
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
     * @ORM\Column(name="pageLimit", type="integer", nullable=true)
     */
    private $pageLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="catFilter", type="string", length=255, nullable=true)
     */
    private $catFilter;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type = 'list';









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
     * Set pageLimit
     *
     * @param integer $pageLimit
     *
     * @return PageListElement
     */
    public function setPageLimit($pageLimit)
    {
        $this->pageLimit = $pageLimit;

        return $this;
    }

    /**
     * Get pageLimit
     *
     * @return int
     */
    public function getPageLimit()
    {
        return $this->pageLimit;
    }

    /**
     * Set catFilter
     *
     * @param string $catFilter
     *
     * @return PageListElement
     */
    public function setCatFilter($catFilter)
    {
        $this->catFilter = $catFilter;

        return $this;
    }

    /**
     * Get catFilter
     *
     * @return string
     */
    public function getCatFilter()
    {
        return $this->catFilter;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }



}

