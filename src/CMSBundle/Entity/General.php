<?php

namespace CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * General
 *
 * @ORM\Table(name="general")
 * @ORM\Entity(repositoryClass="CMSBundle\Repository\GeneralRepository")
 */
class General
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="bgColor", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $bgColor = 'rgb( 93,147,242)';

    /**
     * @var string
     *
     * @ORM\Column(name="bgImage", type="string", length=255, nullable=true)
     */
    private $bgImage;

    /**
     *  @Assert\Image()
     */
    private $bgImageFile;

    /**
     * @return mixed
     */
    public function getBgImageFile()
    {
        return $this->bgImageFile;
    }

    /**
     * @param mixed $bgImageFile
     */
    public function setBgImageFile($bgImageFile)
    {
        $this->bgImageFile = $bgImageFile;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="bsTheme", type="string", length=255, nullable=true)
     */
    private $bsTheme = 'solar';

    /**
     * @var bool
     *
     * @ORM\Column(name="guestMode", type="boolean")
     *
     */
    private $guestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_mail", type="string", length=255)
     * @Assert\Email()
     */
    private $contactMail;





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
     * @return General
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
     * @return General
     */
    public function setBgImage($bgImage)
    {
        $this->bgImage = $bgImage;

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
     * Set bdTheme
     *
     * @param string $bdTheme
     *
     * @return General
     */
    public function setBsTheme($bsTheme)
    {
        $this->bsTheme = $bsTheme;

        return $this;
    }

    /**
     * Get bdTheme
     *
     * @return string
     */
    public function getBsTheme()
    {
        return $this->bsTheme;
    }

    /**
     * Set guestMode
     *
     * @param boolean $guestMode
     *
     * @return General
     */
    public function setGuestMode($guestMode)
    {
        $this->guestMode = $guestMode;

        return $this;
    }

    /**
     * Get guestMode
     *
     * @return bool
     */
    public function getGuestMode()
    {
        return $this->guestMode;
    }

    /**
     * @return string
     */
    public function getContactMail(): string
    {
        return $this->contactMail;
    }

    /**
     * @param string $contactMail
     */
    public function setContactMail(string $contactMail)
    {
        $this->contactMail = $contactMail;
    }

}

