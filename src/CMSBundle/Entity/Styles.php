<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Styles
 *
 * @ORM\Table(name="styles")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\StylesRepository")
 */
class Styles
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
     * @ORM\Column(name="bg_color", type="string", length=255, nullable=true)
     */
    private $bgColor;

    /**
     * @var string
     *
     * @ORM\Column(name="bg_image", type="string", length=255, nullable=true)
     */
    private $bgImage;

    /**
     * @var string
     *
     * @ORM\Column(name="transparency", type="string", length=255, nullable=true)
     */
    private $transparency;

    /**
     * @var string
     *
     * @ORM\Column(name="border_color", type="string", length=255, nullable=true)
     */
    private $borderColor;

    /**
     * @var array
     *
     * @ORM\Column(name="borders", type="json_array", nullable=true)
     */
    private $borders;

    /**
     * @Assert\Range(min = 0,minMessage = "Minimum value must be {{ limit }}!")
     */
    private $topBorder;
    /**
     * @Assert\Range(min = 0,minMessage = "Minimum value must be {{ limit }}!")
     */
    private $bottomBorder;
    /**
     * @Assert\Range(min = 0,minMessage = "Minimum value must be {{ limit }}!")
     */
    private $leftBorder;
    /**
     * @Assert\Range(min = 0,minMessage = "Minimum value must be {{ limit }}!")
     */
    private $rightBorder;

    /**
     * @var int
     *
     * @ORM\Column(name="round_border", type="integer", nullable=true)
     * @Assert\Range(min = 0,minMessage = "Minimum value must be {{ limit }}!")
     */
    private $roundBorder;

    /**
     * @var array
     *
     * @ORM\Column(name="margin", type="json_array", nullable=true)
     */
    private $margin;

    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $topMargin;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $bottomMargin;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $leftMargin;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $rightMargin;


    /**
     * @var array
     *
     * @ORM\Column(name="padding", type="json_array", nullable=true)
     */
    private $padding;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $topPadding;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $bottomPadding;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $leftPadding;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $rightPadding;



    /**
     * @var array
     *
     * @ORM\Column(name="size", type="json_array", nullable=true)
     */
    private $size;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $minWidth;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $maxWidth;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $minHeight;
    /**
     * @Assert\Range(min = 0,max = 100,minMessage = "Minimum value must be {{ limit }}!",maxMessage = "Maximum vaue must be {{ limit }}!")
     */
    private $maxHeight;

    /**
     * @return array
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param array $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getMinWidth()
    {
        return $this->minWidth;
    }

    /**
     * @param mixed $minWidth
     */
    public function setMinWidth($minWidth)
    {
        $this->minWidth = $minWidth;
    }

    /**
     * @return mixed
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * @param mixed $maxWidth
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;
    }

    /**
     * @return mixed
     */
    public function getMinHeight()
    {
        return $this->minHeight;
    }

    /**
     * @param mixed $minHeight
     */
    public function setMinHeight($minHeight)
    {
        $this->minHeight = $minHeight;
    }

    /**
     * @return mixed
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * @param mixed $maxHeight
     */
    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;
    }

    /**
     * @var Positions
     * @ORM\OneToOne(targetEntity="CMSBundle\Entity\Positions", inversedBy="style")
     */
    private $position;








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
     * Set bgColor
     *
     * @param string $bgColor
     *
     * @return Styles
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get bgColor
     *
     * @return string
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Set bgImage
     *
     * @param string $bgImage
     *
     * @return Styles
     */
    public function setBgImage($bgImage)
    {
        $this->bgImage = $bgImage;

        return $this;
    }

    /**
     * Get bgImage
     *
     * @return string
     */
    public function getBgImage()
    {
        return $this->bgImage;
    }

    /**
     * Set transparency
     *
     * @param string $transparency
     *
     * @return Styles
     */
    public function setTransparency($transparency)
    {
        $this->transparency = $transparency;

        return $this;
    }

    /**
     * Get transparency
     *
     * @return string
     */
    public function getTransparency()
    {
        return $this->transparency;
    }

    /**
     * Set borderColor
     *
     * @param string $borderColor
     *
     * @return Styles
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    /**
     * Get borderColor
     *
     * @return string
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * Set borders
     *
     * @param array $borders
     *
     * @return Styles
     */
    public function setBorders($borders)
    {
        $this->borders = $borders;

        return $this;
    }

    /**
     * Get borders
     *
     * @return array
     */
    public function getBorders()
    {
        return $this->borders;
    }

    /**
     * Set margin
     *
     * @param array $margin
     *
     * @return Styles
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;

        return $this;
    }

    /**
     * Get margin
     *
     * @return array
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * Set padding
     *
     * @param array $padding
     *
     * @return Styles
     */
    public function setPadding($padding)
    {
        $this->padding = $padding;

        return $this;
    }

    /**
     * Get padding
     *
     * @return array
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * @return Positions
     */
    public function getPosition(): Positions
    {
        return $this->position;
    }

    /**
     * @param Positions $position
     */
    public function setPosition(Positions $position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getTopBorder()
    {
        return $this->topBorder;
    }

    /**
     * @param mixed $topBorder
     */
    public function setTopBorder($topBorder)
    {
        $this->topBorder = $topBorder;
    }

    /**
     * @return mixed
     */
    public function getBottomBorder()
    {
        return $this->bottomBorder;
    }

    /**
     * @param mixed $bottomBorder
     */
    public function setBottomBorder($bottomBorder)
    {
        $this->bottomBorder = $bottomBorder;
    }

    /**
     * @return mixed
     */
    public function getLeftBorder()
    {
        return $this->leftBorder;
    }

    /**
     * @param mixed $leftBorder
     */
    public function setLeftBorder($leftBorder)
    {
        $this->leftBorder = $leftBorder;
    }

    /**
     * @return mixed
     */
    public function getRightBorder()
    {
        return $this->rightBorder;
    }

    /**
     * @param mixed $rightBorder
     */
    public function setRightBorder($rightBorder)
    {
        $this->rightBorder = $rightBorder;
    }

    /**
     * @return mixed
     */
    public function getTopMargin()
    {
        return $this->topMargin;
    }

    /**
     * @param mixed $topMargin
     */
    public function setTopMargin($topMargin)
    {
        $this->topMargin = $topMargin;
    }

    /**
     * @return mixed
     */
    public function getBottomMargin()
    {
        return $this->bottomMargin;
    }

    /**
     * @param mixed $bottomMargin
     */
    public function setBottomMargin($bottomMargin)
    {
        $this->bottomMargin = $bottomMargin;
    }

    /**
     * @return mixed
     */
    public function getLeftMargin()
    {
        return $this->leftMargin;
    }

    /**
     * @param mixed $leftMargin
     */
    public function setLeftMargin($leftMargin)
    {
        $this->leftMargin = $leftMargin;
    }

    /**
     * @return mixed
     */
    public function getRightMargin()
    {
        return $this->rightMargin;
    }

    /**
     * @param mixed $rightMargin
     */
    public function setRightMargin($rightMargin)
    {
        $this->rightMargin = $rightMargin;
    }

    /**
     * @return mixed
     */
    public function getTopPadding()
    {
        return $this->topPadding;
    }

    /**
     * @param mixed $topPadding
     */
    public function setTopPadding($topPadding)
    {
        $this->topPadding = $topPadding;
    }

    /**
     * @return mixed
     */
    public function getBottomPadding()
    {
        return $this->bottomPadding;
    }

    /**
     * @param mixed $bottomPadding
     */
    public function setBottomPadding($bottomPadding)
    {
        $this->bottomPadding = $bottomPadding;
    }

    /**
     * @return mixed
     */
    public function getLeftPadding()
    {
        return $this->leftPadding;
    }

    /**
     * @param mixed $leftPadding
     */
    public function setLeftPadding($leftPadding)
    {
        $this->leftPadding = $leftPadding;
    }

    /**
     * @return mixed
     */
    public function getRightPadding()
    {
        return $this->rightPadding;
    }

    /**
     * @param mixed $rightPadding
     */
    public function setRightPadding($rightPadding)
    {
        $this->rightPadding = $rightPadding;
    }

    /**
     * @return int
     */
    public function getRoundBorder()
    {
        return $this->roundBorder;
    }

    /**
     * @param int $roundBorder
     */
    public function setRoundBorder(int $roundBorder = null)
    {
        $this->roundBorder = $roundBorder;
    }


}

